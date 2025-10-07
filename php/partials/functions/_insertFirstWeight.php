<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function insertWeights($conn, $weighing_id, $weighment_type, $weights, $materials = [], $charges = [])
{
    $weighment_type = isset($weighment_type) ? $weighment_type : 1;
    $checkStmt = $conn->prepare("SELECT 1 FROM weights WHERE weighingrecord_id = ? AND weight_count = ? LIMIT 1");
    $insertStmt = $conn->prepare("INSERT INTO weights (weighingrecord_id, weightment_type, weight, material, charges, weight_count, weighed_on) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($weights as $index => $weight) {
        $weight_count = $index + 1;
        $material = isset($materials[$index]) ? $materials[$index] : null;
        $charge = isset($charges[$index]) ? $charges[$index] : null;

        $checkStmt->bind_param("ii", $weighing_id, $weight_count);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows === 0) {
            $weighed_on = date('Y-m-d H:i:s');
            $insertStmt->bind_param("iiisdis", $weighing_id, $weighment_type, $weight, $material, $charge, $weight_count, $weighed_on);
            $insertStmt->execute();
        }
    }

    $checkStmt->close();
    $insertStmt->close();
}


function insertFirstWeight($conn, $data)
{
    $weighment_type = isset($data['weighment_type']) ? $data['weighment_type'] : 1;
    $ticket_no      = isset($data['ticket_no']) ? $data['ticket_no'] : 123;
    $vehicle_no     = isset($data['vehicle_number']) ? $data['vehicle_number'] : null;
    $party_name     = isset($data['party_name']) ? $data['party_name'] : null;
    $charges        = isset($data['charges']) ? $data['charges'] : 0;
    $status         = isset($data['status']) ? $data['status'] : 1;
    $weights        = [];
    $materials      = [];
    $charges        = [];

    foreach ($data as $key => $value) {
        if (strpos($key, 'weight_') === 0 && !empty($value)) {
            $index = (int)str_replace('weight_', '', $key);
            $weights[$index] = $value;
        }
        if (strpos($key, 'material_') === 0) {
            $index = (int)str_replace('material_', '', $key);
            $materials[$index] = $value;
        }
        if (strpos($key, 'charges_') === 0) {
            $index = (int)str_replace('charges_', '', $key);
            $charges[$index] = $value;
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
        insertWeights($conn, $weighing_id, $weighment_type, $weights, $materials, $charges);
        $response = ['status' => true, 'message' => 'Weigh Record Exists, updating weights.'];
    } else {

        $sql = "INSERT INTO `weighing_record`
                (`weighment_type`, `ticket_no`, `vehicle_number`, `party_name`, `charges`, `created_at`,`status` ) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("iissisi", $weighment_type, $ticket_no, $vehicle_no, $party_name, $charges, $created_at, $status);
        $res = $stmt->execute();
        if ($res) {
            $response = ['status' => true, 'message' => 'Weighing record inserted.'];
        } else {
            $response = ['status' => false, 'message' => 'Failed to insert weighing recoed'];
        }
        $weighing_id = $conn->insert_id;
        insertWeights($conn, $weighing_id, $weighment_type, $weights, $materials, $charges);
        $stmt->close();
    }

    echo json_encode($response);
}
