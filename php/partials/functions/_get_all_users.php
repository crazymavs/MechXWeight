<?php
function getAllUsers($conn)
{
    $users = [];

    $sql = "SELECT user_id, user_name, user_username, user_email, user_is_active, user_type, user_created_at FROM users ORDER BY user_created_at DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    echo json_encode(['status' => true, 'data' => $users]);
}
