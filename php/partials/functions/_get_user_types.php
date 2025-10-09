<?php
function getUserTypes($conn)
{
    $userTypes = [];

    $sql = "SELECT user_type_id, user_type FROM user_type";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $userTypes[] = $row;
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => false, 'message' => "Database query preparation failed: " . $conn->error]);
        return;
    }

    echo json_encode(['status' => true, 'data' => $userTypes]);
}
