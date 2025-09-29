<?php
function insertParty($conn, $data)
{
    $party_name = $data['party_name'];
    $party_email = isset($data['party_email']) ? $data['party_email'] : null;
    $party_phone = isset($data['party_phone']) ? $data['party_phone'] : null;
    $status = isset($data['party_status']) ? (int)$data['party_status'] : 1;
    $created_at = date('Y-m-d H:i:s');

    if (isset($data['party_id']) && !empty($data['party_id'])) {
        // Edit existing party
        $party_id = (int)$data['party_id'];

        $updateSql = "UPDATE parties SET party_name = ?, party_email = ?, party_phone = ?, party_status = ? WHERE party_id = ?";
        if ($updateStmt = $conn->prepare($updateSql)) {
            $updateStmt->bind_param("sssii", $party_name, $party_email, $party_phone, $status, $party_id);
            if ($updateStmt->execute()) {
                $response = ['status' => true, 'id' => $party_id, 'message' => "Party updated successfully"];
            } else {
                $response = ['status' => false, 'error' => $updateStmt->error, 'message' => "Error updating party"];
            }
            $updateStmt->close();
        } else {
            $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare update statement"];
        }
    } else {
        // Check if party_email already exists before inserting
        $checkEmailSql = "SELECT party_id FROM parties WHERE party_email = ?";
        if ($checkEmailStmt = $conn->prepare($checkEmailSql)) {
            $checkEmailStmt->bind_param("s", $party_email);
            $checkEmailStmt->execute();
            $emailResult = $checkEmailStmt->get_result();

            if ($emailRow = $emailResult->fetch_assoc()) {
                // Email already exists
                $response = ['status' => false, 'message' => "Party email already exists", 'id' => $emailRow['party_id']];
            } else {
                $checkEmailStmt->close();

                // Insert new party
                $insertSql = "INSERT INTO parties (party_name, party_email, party_phone, party_status, party_created_at) VALUES (?, ?, ?, ?, ?)";
                if ($insertStmt = $conn->prepare($insertSql)) {
                    $insertStmt->bind_param("sssis", $party_name, $party_email, $party_phone, $status, $created_at);
                    if ($insertStmt->execute()) {
                        $insertedId = $insertStmt->insert_id;
                        $response = ['status' => true, 'id' => $insertedId, 'message' => "Party inserted successfully"];
                    } else {
                        $response = ['status' => false, 'error' => $insertStmt->error, 'message' => "Error inserting party"];
                    }
                    $insertStmt->close();
                } else {
                    $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare insert statement"];
                }
            }
        } else {
            $response = ['status' => false, 'error' => $conn->error, 'message' => "Failed to prepare email check statement"];
        }
    }

    echo json_encode($response);
}
