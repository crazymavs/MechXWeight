<?php
function save_label_config($conn, $data)
{
    $created_at = date('Y-m-d H:i:s');
    $table_name = "label_config";
    $responses = [];
    $company_id = 1;

    $label_id = 1; // Initialize label_id counter

    foreach ($data as $key => $value) {
        // Skip non-field keys
        if (in_array($key, ['actionMethod'])) continue;

        // Check if record exists for current company_id and column_name
        $checkSql = "SELECT label_id FROM label_mapping WHERE company_id = ? AND column_name = ?";
        if ($checkStmt = $conn->prepare($checkSql)) {
            $checkStmt->bind_param("is", $company_id, $key);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Record exists - do update
                $existing_label_id = $row['label_id'];
                $updateSql = "UPDATE label_mapping SET label_name = ? WHERE company_id = ? AND column_name = ?";
                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("sis", $value, $company_id, $key);
                    if ($updateStmt->execute()) {
                        $responses[] = ['status' => true, 'key' => $key, 'label_id' => $existing_label_id, 'message' => "Updated"];
                    } else {
                        $responses[] = ['status' => false, 'key' => $key, 'error' => $updateStmt->error];
                    }
                    $updateStmt->close();
                } else {
                    $responses[] = ['status' => false, 'key' => $key, 'error' => $conn->error];
                }
            } else {
                // Record does not exist - do insert
                $current_label_id = $label_id++;
                $insertSql = "INSERT INTO label_mapping (company_id, label_id, table_name, column_name, label_name) VALUES (?, ?, ?, ?, ?)";
                if ($insertStmt = $conn->prepare($insertSql)) {
                    $insertStmt->bind_param("iisss", $company_id, $current_label_id, $table_name, $key, $value,);
                    if ($insertStmt->execute()) {
                        $responses[] = ['status' => true, 'key' => $key, 'label_id' => $current_label_id, 'message' => "Inserted"];
                    } else {
                        $responses[] = ['status' => false, 'key' => $key, 'error' => $insertStmt->error];
                    }
                    $insertStmt->close();
                } else {
                    $responses[] = ['status' => false, 'key' => $key, 'error' => $conn->error];
                }
            }
            $checkStmt->close();
        } else {
            $responses[] = ['status' => false, 'key' => $key, 'error' => $conn->error];
        }
    }
    echo json_encode($responses);
}
