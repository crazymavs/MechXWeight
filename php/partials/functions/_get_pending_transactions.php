<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getPendingWeighingTransactions($conn, $data)
{
    $from_date = $data['from_date'];
    $till_date = $data['till_date'];
    $records = [];

    $where = '';
    $params = [];
    $types = '';

    if ($from_date) {
        $where .= ' AND wr.created_at >= ?';
        $params[] = $from_date;
        $types .= 's';
    }
    if ($till_date) {
        $where .= ' AND wr.created_at <= ?';
        $params[] = $till_date;
        $types .= 's';
    }

    $sql = "
        SELECT
            wr.*,
            w.weight,
            w.weightment_type,
            w.weight_count,
            w.weighed_on,
            w.material,
            w.charges
        FROM
            weighing_record wr
        LEFT JOIN
            weights w ON wr.weighingrecord_id = w.weighingrecord_id
        WHERE
            wr.status = 1
            $where
        ORDER BY
            wr.created_at DESC, w.weight_count ASC
    ";
    if ($stmt = $conn->prepare($sql)) {
        // Only bind if there are params
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }

        $stmt->close();
    } else {
        // Handle prepare error appropriately, e.g. throw exception or return error
        throw new Exception("Database query preparation failed: " . $conn->error);
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
    }

    echo json_encode(['status' => true, 'data' => $records]);
}
