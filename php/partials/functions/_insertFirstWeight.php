<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function insertWeights($conn, $weighing_id, $weighment_type, $weights)
{
    $checkStmt = $conn->prepare("SELECT 1 FROM weights WHERE weighingrecord_id = ? AND weight_count = ? LIMIT 1");
    $insertStmt = $conn->prepare("INSERT INTO weights (weighingrecord_id, weightment_type, weight, weight_count, weighed_on) VALUES (?, ?, ?, ?, ?)");

    foreach ($weights as $index => $weight) {
        $weight_count = $index + 1;

        $checkStmt->bind_param("ii", $weighing_id, $weight_count);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows === 0) {
            $weighed_on = date('Y-m-d H:i:s');
            $insertStmt->bind_param("iiiis", $weighing_id, $weighment_type, $weight, $weight_count, $weighed_on);
            $insertStmt->execute();
        }
    }

    $checkStmt->close();
    $insertStmt->close();
}

function insertFirstWeight($conn, $data)
{
    $weighment_type = isset($data['weighment_type']) ? $data['weighment_type'] : null;
    $ticket_no      = isset($data['ticket_no']) ? $data['ticket_no'] : null;
    $vehicle_no     = isset($data['vehicle_no']) ? $data['vehicle_no'] : null;
    $party_name     = isset($data['party_name']) ? $data['party_name'] : null;
    $material       = isset($data['material']) ? $data['material'] : null;
    $charges        = isset($data['charges']) ? $data['charges'] : null;
    $weights = [];

    foreach ($data as $key => $value) {
        if (strpos($key, 'weight_') === 0 && !empty($value)) {
            $weights[] = $value;
        }
    }

    $created_at     = date('Y-m-d H:i:s');
    $checkSql = "SELECT weighingrecord_id  FROM weighing_record WHERE ticket_no = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $ticket_no);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $row = $result->fetch_assoc();
    $checkStmt->close();

    if ($row) {
        // Duplicate ticket_no
        $weighing_id = $row['weighingrecord_id'];
        insertWeights($conn, $weighing_id, $weighment_type, $weights);
        $response = ['status' => true, 'message' => 'Weigh Record Exists, updating weights.'];
    } else {

        $sql = "INSERT INTO `weighing_record`
                (`weighment_type`, `ticket_no`, `vehicle_number`, `party_name`, `material`, `charges`, `created_at`,`is_pending` ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $is_pending = 1;
        $stmt->bind_param("iisssisi", $weighment_type, $ticket_no, $vehicle_no, $party_name, $material, $charges, $created_at, $is_pending);
        $res = $stmt->execute();
        if ($res) {
            $response = ['status' => true, 'message' => 'Weighing record inserted.'];
        } else {
            $response = ['status' => false, 'message' => 'Failed to insert weighing recoed'];
        }
        $weighing_id = $conn->insert_id;
        insertWeights($conn, $weighing_id, $weighment_type, $weights);
        $stmt->close();
    }

    echo json_encode($response);
}
