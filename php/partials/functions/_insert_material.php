<?php
function insertMaterial($conn, $data)
{
    $material_name = $data['material_name'];
    $isActive = isset($data['is_active']) ? (int)$data['is_active'] : 1;

    if (isset($data['material_id']) && !empty($data['material_id'])) {
        // Edit scenario using provided material_id
        $material_id = (int)$data['material_id'];

        $updateSql = "UPDATE material SET material_name = ?, is_active = ? WHERE material_id = ?";
        if ($updateStmt = $conn->prepare($updateSql)) {
            $updateStmt->bind_param("sii", $material_name, $isActive, $material_id);
            if ($updateStmt->execute()) {
                $response = ['status' => true, 'id' => $material_id, 'message' => "Material updated successfully"];
            } else {
                $response = ['status' => false, 'error' => $updateStmt->error, 'message' => "Error updating material"];
            }
            $updateStmt->close();
        } else {
            $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare update statement"];
        }
    } else {
        // Check if material_name already exists
        $checkSql = "SELECT material_id FROM material WHERE material_name = ?";
        if ($checkStmt = $conn->prepare($checkSql)) {
            $checkStmt->bind_param("s", $material_name);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Material name already exists
                $response = ['status' => false, 'message' => "Material name already exists", 'id' => $row['material_id']];
            } else {
                // Name not found, proceed to insert
                $checkStmt->close();

                $insertSql = "INSERT INTO material (material_name, is_active) VALUES (?, ?)";
                if ($insertStmt = $conn->prepare($insertSql)) {
                    $insertStmt->bind_param("si", $material_name, $isActive);
                    if ($insertStmt->execute()) {
                        $insertedId = $insertStmt->insert_id;
                        $response = ['status' => true, 'id' => $insertedId, 'message' => "Material inserted successfully"];
                    } else {
                        $response = ['status' => false, 'error' => $insertStmt->error, 'message' => "Error inserting material"];
                    }
                    $insertStmt->close();
                } else {
                    $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare insert statement"];
                }
            }
        } else {
            $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare check statement"];
        }
    }

    echo json_encode($response);
}
