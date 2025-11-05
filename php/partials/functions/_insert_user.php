<?php
function adduser($conn, $data)
{
    // Validate required fields including user_id
    $requiredFields = ['user_name', 'user_username', 'user_email', 'user_password', 'user_is_active', 'user_type'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || $data[$field] === '') {
            echo json_encode(['status' => false, 'message' => "$field is required"]);
            return;
        }
    }

    $userId = isset($data['user_id']) ? (int)$data['user_id'] : 0;
    $userEmail = $data['user_email'];
    $userUsername = $data['user_username'];

    // Check for duplicates by email or username, excluding the current user_id (if updating)
    $sqlCheck = "SELECT user_id FROM users WHERE (user_email = ? OR user_username = ?)";
    $params = [$userEmail, $userUsername];
    $types = "ss";

    if ($userId > 0) {
        $sqlCheck .= " AND user_id != ?";
        $params[] = $userId;
        $types .= "i";
    }

    if ($stmtCheck = $conn->prepare($sqlCheck)) {
        $stmtCheck->bind_param($types, ...$params);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            echo json_encode(['status' => false, 'message' => 'Duplicate user email or username found']);
            $stmtCheck->close();
            return;
        }
        $stmtCheck->close();
    } else {
        echo json_encode(['status' => false, 'message' => 'Duplicate check preparation failed: ' . $conn->error]);
        return;
    }

    if ($userId > 0) {
        // Update user if user_id exists
        $sqlUpdate = "UPDATE users SET 
                    user_name = ?, 
                    user_username = ?, 
                    user_email = ?, 
                    user_password = ?, 
                    user_is_active = ?, 
                    user_type = ? 
                  WHERE user_id = ?";

        if ($stmtUpdate = $conn->prepare($sqlUpdate)) {
            $hashedPassword = password_hash($data['user_password'], PASSWORD_DEFAULT);

            $stmtUpdate->bind_param(
                "ssssiis",
                $data['user_name'],
                $data['user_username'],
                $data['user_email'],
                $hashedPassword,  // Pre-hashed password
                $data['user_is_active'],
                $data['user_type'],
                $userId
            );

            if ($stmtUpdate->execute()) {
                if ($stmtUpdate->affected_rows > 0) {
                    echo json_encode(['status' => true, 'message' => 'User updated successfully']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'No changes made or user not found']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Execution failed: ' . $stmtUpdate->error]);
            }
            $stmtUpdate->close();
        } else {
            echo json_encode(['status' => false, 'message' => 'Update preparation failed: ' . $conn->error]);
        }
    } else {
        // Insert new user if no user_id provided (or 0)
        $sqlInsert = "INSERT INTO users (user_name, user_username, user_email, user_password, user_is_active, user_type, user_created_at, user_company) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
        $hashedPassword = password_hash($data['user_password'], PASSWORD_DEFAULT);
        if ($stmtInsert = $conn->prepare($sqlInsert)) {
            $stmtInsert->bind_param(
                "ssssiii",
                $data['user_name'],
                $data['user_username'],
                $data['user_email'],
                $hashedPassword,
                $data['user_is_active'],
                $data['user_type'],
                $data['user_company']
            );

            if ($stmtInsert->execute()) {
                echo json_encode(['status' => true, 'message' => 'User created successfully', 'user_id' => $stmtInsert->insert_id]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Execution failed: ' . $stmtInsert->error]);
            }
            $stmtInsert->close();
        } else {
            echo json_encode(['status' => false, 'message' => 'Insert preparation failed: ' . $conn->error]);
        }
    }
}
