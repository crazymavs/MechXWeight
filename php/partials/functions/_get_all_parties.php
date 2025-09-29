<?php
function getAllParties($conn)
{
    $parties = [];

    $sql = "SELECT party_id, party_name, party_email, party_phone, party_status, party_created_at FROM parties ORDER BY party_created_at DESC";

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

function getPartyById($conn, $data)
{
    if (!isset($data['party_id'])) {
        echo json_encode(['status' => false, 'message' => 'Party ID is required']);
        return;
    }

    $party_id = $data['party_id'];
    $party = null;

    $sql = "SELECT party_id, party_name, party_email, party_phone, party_status, party_created_at FROM parties WHERE party_id = ? LIMIT 1";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $party_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $party = $row;
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    if ($party) {
        echo json_encode(['status' => true, 'data' => $party]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Party not found']);
    }
}
