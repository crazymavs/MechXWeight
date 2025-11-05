<?php
function deletePartyById($conn, $data)
{
    $partyId = $data['party_id'];
    $sql = "DELETE FROM parties WHERE party_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $partyId);

        if ($stmt->execute()) {
            $affectedRows = $stmt->affected_rows;
            $stmt->close();

            if ($affectedRows > 0) {
                $response = ['status' => true, 'message' => 'Party deleted successfully'];
            } else {
                $response = ['status' => false, 'message' => 'No party found with the given ID'];
            }
        } else {
            $error = $stmt->error;
            $stmt->close();
            $response = ['status' => false, 'error' => $error];
        }
    } else {
        $response = ['status' => false, 'error' => $conn->error];
    }

    echo json_encode($response);
}
