<?php
function insertParty($conn, $data)
{
    $sql = "INSERT INTO parties (party_name, party_email, party_phone, party_status, party_created_at) 
            VALUES (?, ?, ?, ?, ?)";

    $created_at = date('Y-m-d H:i:s');
    $status = 1; // Active status by default

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "sssis",
            $data['party_name'],
            $data['party_email'],
            $data['party_phone'],
            $status,
            $created_at
        );

        if ($stmt->execute()) {
            $insertedId = $stmt->insert_id;
            $stmt->close();
            $response = ['status' => true, 'id' => $insertedId, 'message' => "Successfully inserted Party"];
        } else {
            $error = $stmt->error;
            $stmt->close();
            $response = ['status' => false, 'error' => $error, 'message' => "Error while inserting Party"];
        }
    } else {
        $response = ['status' => false, 'error' => $conn->error, 'message' => "Error while inserting Party"];
    }
    echo json_encode($response);
}
