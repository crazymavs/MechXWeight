<?php
function deleteUser($conn, $data)
{
    if (!isset($data['user_id']) || empty($data['user_id'])) {
        echo json_encode(['status' => false, 'message' => 'user_id is required']);
        return;
    }

    $userId = (int)$data['user_id'];

    $sql = "DELETE FROM users WHERE user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => true, 'message' => 'User deleted successfully']);
            } else {
                echo json_encode(['status' => false, 'message' => 'User not found or already deleted']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Execution failed: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => 'Preparation failed: ' . $conn->error]);
    }
}
