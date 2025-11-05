<?php
function save_label_config($conn, $data)
{
    // echo json_encode($data);
    $created_at = date('Y-m-d H:i:s');
    $table_name = "label_config";
    $responses = [];
    $company_id = 1;

    $label_id = 1; // Initialize label_id counter

    foreach ($data as $key => $value) {
        if (in_array($key, ['actionMethod'])) continue;

        $labelname = $value['value'];
        $enabled = $value['enabled'] ? 1 : 0;
        // Skip non-field keys

        // Check if record exists for current company_id and column_name
        $checkSql = "SELECT label_id FROM label_mapping WHERE company_id = ? AND column_name = ?";
        if ($checkStmt = $conn->prepare($checkSql)) {
            $checkStmt->bind_param("is", $company_id, $key);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Record exists - do update
                $existing_label_id = $row['label_id'];
                $updateSql = "UPDATE label_mapping SET label_name = ?, enabled = ? WHERE company_id = ? AND column_name = ?";
                if ($updateStmt = $conn->prepare($updateSql)) {
                    // Note the change from "sis" => "siis" and the updated bind_param values
                    $updateStmt->bind_param("siis", $labelname, $enabled, $company_id, $key);
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
                $insertSql = "INSERT INTO label_mapping (company_id, label_id, table_name, column_name, label_name, enabled) VALUES (?, ?, ?, ?, ?, ?)";
                if ($insertStmt = $conn->prepare($insertSql)) {
                    $insertStmt->bind_param("iisssi", $company_id, $current_label_id, $table_name, $key, $labelname, $enabled);
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
    // Determine overall status - success if no errors
    $overallStatus = count(array_filter($responses, fn($r) => $r['status'] === false)) === 0;

    // Respond with single object
    $responseObj = [
        'status' => $overallStatus,
        'message' => $overallStatus ? 'All labels saved successfully' : 'Some labels failed to save',
        'data' => $responses
    ];

    echo json_encode($responseObj);
}
