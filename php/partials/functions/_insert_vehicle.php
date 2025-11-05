<?php
function insertVehicle($conn, $data)
{
    $vehicle_owner = isset($data['owner_name']) ? $data['owner_name'] : null;
    $vehicle_number = isset($data['vehicle_number']) ? $data['vehicle_number'] : null;
    $vehicle_weight = isset($data['vehicle_weight']) ? (int)$data['vehicle_weight'] : 0;
    $status = isset($data['vehicle_status']) ? (int)$data['vehicle_status'] : 1;
    $created_at = date('Y-m-d H:i:s');
    $company_id = isset($data['company_id']) ? (int)$data['company_id'] : null;

    if ($company_id === null) {
        echo json_encode(['status' => false, 'message' => "Missing company_id"]);
        return;
    }

    if (isset($data['vehicle_id']) && !empty($data['vehicle_id'])) {
        // Edit existing vehicle
        $vehicle_id = (int)$data['vehicle_id'];

        $updateSql = "UPDATE vehicles SET vehicle_owner = ?, vehicle_number = ?, vehicle_weight = ?, vehicle_status = ?, company_id = ? WHERE vehicle_id = ?";
        if ($updateStmt = $conn->prepare($updateSql)) {
            $updateStmt->bind_param("ssiiii", $vehicle_owner, $vehicle_number, $vehicle_weight, $status, $company_id, $vehicle_id);
            if ($updateStmt->execute()) {
                $response = ['status' => true, 'id' => $vehicle_id, 'message' => "Vehicle updated successfully"];
            } else {
                $response = ['status' => false, 'error' => $updateStmt->error, 'message' => "Error updating vehicle"];
            }
            $updateStmt->close();
        } else {
            $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare update statement"];
        }
    } else {
        // Check if vehicle_number already exists for the same company before inserting
        $checkSql = "SELECT vehicle_id FROM vehicles WHERE vehicle_number = ? AND company_id = ?";
        if ($checkStmt = $conn->prepare($checkSql)) {
            $checkStmt->bind_param("si", $vehicle_number, $company_id);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Vehicle number already exists for this company
                $response = ['status' => false, 'message' => "Vehicle number already exists", 'id' => $row['vehicle_id']];
            } else {
                $checkStmt->close();

                // Insert new vehicle with company_id
                $insertSql = "INSERT INTO vehicles (vehicle_owner, vehicle_number, vehicle_created_at, vehicle_status, vehicle_weight, company_id)
                              VALUES (?, ?, ?, ?, ?, ?)";
                if ($insertStmt = $conn->prepare($insertSql)) {
                    $insertStmt->bind_param("sssiii", $vehicle_owner, $vehicle_number, $created_at, $status, $vehicle_weight, $company_id);
                    if ($insertStmt->execute()) {
                        $insertedId = $insertStmt->insert_id;
                        $response = ['status' => true, 'id' => $insertedId, 'message' => "Vehicle inserted successfully"];
                    } else {
                        $response = ['status' => false, 'error' => $insertStmt->error, 'message' => "Error inserting vehicle"];
                    }
                    $insertStmt->close();
                } else {
                    $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare insert statement"];
                }
            }
        } else {
            $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare vehicle number check statement"];
        }
    }

    echo json_encode($response);
}
