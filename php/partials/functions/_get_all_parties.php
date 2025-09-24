<?php
function getAllParties($conn)
{
    $parties = [];

    $sql = "SELECT parties_id, party_name, party_email, party_phone, party_status, party_created_at FROM parties ORDER BY party_created_at DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $parties[] = $row;
        }

        $stmt->close();
    } else {
        throw new Exception("Database query preparation failed: " . $conn->error);
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    echo json_encode(['status' => true, 'data' => $parties]);
}
