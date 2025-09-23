<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function getWeighingRecordById($conn, $data)
{

    $ticketNo = intval($data['ticket_no']);
    $record = null;

    $sql = "SELECT 
                wr.*, 
                COALESCE(GROUP_CONCAT(w.weight ORDER BY w.weighingrecord_id), '') AS weights
            FROM 
                weighing_record wr
            LEFT JOIN 
                weights w ON wr.weighingrecord_id = w.weighingrecord_id
            WHERE 
                wr.ticket_no = ?
            GROUP BY 
                wr.weighingrecord_id
            LIMIT 1";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $ticketNo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $record = $row;
        }

        $stmt->close();
    } else {
        throw new Exception("Database query preparation failed: " . $conn->error);
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    echo json_encode(['status' => true, 'data' => $record]);
}
