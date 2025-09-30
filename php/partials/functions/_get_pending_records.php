<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getPendingWeighingRecords($conn)
{
    $records = [];

    // $sql = "SELECT * FROM weighing_record ORDER BY created_at DESC";
    // $sql = "SELECT 
    //             wr.*, 
    //             GROUP_CONCAT(w.weight ORDER BY w.weighingrecord_id) AS weights
    //         FROM 
    //             weighing_record wr
    //         LEFT JOIN 
    //             weights w ON wr.weighingrecord_id = w.weighingrecord_id
    //         GROUP BY 
    //             wr.weighingrecord_id
    //         ORDER BY 
    //             wr.created_at DESC;
    // ";
    // Join each weights row to its weighing_record. Each weight row is a separate output row.
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
        ORDER BY
            wr.created_at DESC, w.weight_count ASC
    ";
    if ($stmt = $conn->prepare($sql)) {
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
