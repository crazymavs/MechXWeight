<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getAllWeighingRecords($conn, $data)
{
    $from_date = $data['from_date'];
    $till_date = $data['till_date'];
    $company_id = isset($data['company_id']) ? $data['company_id'] : null;
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
    if ($company_id !== null) {
        $where .= ' AND wr.company_id = ?';  // assuming company_id is stored in weighing_record as wr.company_id
        $params[] = $company_id;
        $types .= 'i';
    }

    $sql = "
        SELECT
            wr.*,
            w.weight,
            w.weightment_type,
            w.weight_count,
            w.weighed_on,
            w.material,
            w.net_weight,
            w.charges
        FROM
            weighing_record wr
        LEFT JOIN
            weights w ON wr.weighingrecord_id = w.weighingrecord_id
        WHERE 1 = 1
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
