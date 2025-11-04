<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function insertWeights($conn, $weighing_id, $weighment_type, $weights, $net_weights = [], $materials = [], $charges = [])
{
    $weighment_type = isset($weighment_type) ? $weighment_type : 1;
    $checkStmt = $conn->prepare("SELECT 1 FROM weights WHERE weighingrecord_id = ? AND weight_count = ? LIMIT 1");
    $insertStmt = $conn->prepare("INSERT INTO weights (weighingrecord_id, weightment_type, weight, net_weight, material, charges, weight_count, weighed_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($weights as $index => $weight) {
        $weight_count = $index + 1;
        $material = isset($materials[$index]) ? $materials[$index] : null;
        $charge = isset($charges[$index]) ? $charges[$index] : null;
        $net_weight = isset($net_weights[$index]) ? $net_weights[$index] : 0;
        $checkStmt->bind_param("ii", $weighing_id, $weight_count);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows === 0) {
            $weighed_on = date('Y-m-d H:i:s');
            $insertStmt->bind_param("iiiisdis", $weighing_id, $weighment_type, $weight, $net_weight, $material, $charge, $weight_count, $weighed_on);
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
    $status         = isset($data['status']) ? $data['status'] : 1;
    $company_id     = isset($data['company_id']) ? (int)$data['company_id'] : null;

    if ($company_id === null) {
        echo json_encode(['status' => false, 'message' => "Missing company_id"]);
        return;
    }

    $weights        = [];
    $net_weights    = [];
    $materials      = [];
    $charges        = [];

    foreach ($data as $key => $value) {
        if (strpos($key, 'weight_') === 0 && !empty($value)) {
            $index = (int)str_replace('weight_', '', $key);
            $weights[$index] = $value;
        }
        if (strpos($key, 'netweight_') === 0 && !empty($value)) {
            $index = (int)str_replace('netweight_', '', $key);
            $net_weights[$index] = $value;
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

    $created_at = date('Y-m-d H:i:s');

    // Adjust ticket_no duplicate check to also filter by company_id if needed
    $checkSql = "SELECT weighingrecord_id FROM weighing_record WHERE ticket_no = ? AND company_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $ticket_no, $company_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $row = $result->fetch_assoc();
    $checkStmt->close();

    if ($row) {
        // Duplicate ticket_no for this company
        $weighing_id = $row['weighingrecord_id'];
        insertWeights($conn, $weighing_id, $weighment_type, $weights, $net_weights, $materials, $charges);
        $response = ['status' => true, 'message' => 'Weigh Record Exists, updating weights.'];
    } else {
        $sql = "INSERT INTO `weighing_record`
                (`weighment_type`, `ticket_no`, `vehicle_number`, `party_name`, `created_at`, `status`, `company_id`) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("iisssii", $weighment_type, $ticket_no, $vehicle_no, $party_name, $created_at, $status, $company_id);
        $res = $stmt->execute();
        if ($res) {
            $response = ['status' => true, 'message' => 'Weighing record inserted.'];
        } else {
            $response = ['status' => false, 'message' => 'Failed to insert weighing record'];
        }
        $weighing_id = $conn->insert_id;
        insertWeights($conn, $weighing_id, $weighment_type, $weights, $net_weights, $materials, $charges);
        $stmt->close();
    }

    echo json_encode($response);
}
