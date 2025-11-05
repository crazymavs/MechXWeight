<?php

function registerUser($conn, $data)
{
    // Extract values from $data object
    $name = $data['user_name'] ?? '';
    $username = $data['user_username'] ?? '';
    $email = $data['user_email'] ?? '';
    $password = $data['user_password'] ?? '';
    $isAdmin = isset($data['user_is_admin']) ? (int)$data['user_is_admin'] : 1;
    $isActive = isset($data['user_is_active']) ? (int)$data['user_is_active'] : 1;
    $userType = $data['user_type'] ?? 1;
    $userCompany = $data['user_company'] ?? '';

    // Validate mandatory fields (example)
    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        return false; // Required fields missing
    }

    // Hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare SQL statement
    $sql = "INSERT INTO users (user_name, user_username, user_email, user_password, user_is_admin, user_is_active, user_created_at, user_type, user_company) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssiiis",
            $name,
            $username,
            $email,
            $hashedPassword,
            $isAdmin,
            $isActive,
            $userType,
            $userCompany
        );

        if ($stmt->execute()) {
            $stmt->close();
            include_once 'php/partials/functions/_login_user.php';
            loginUser($conn, ['user_identifier' => $username, 'user_password' => $password]);
        } else {
            $stmt->close();
            echo json_encode([
                "status" => false,
                "message" => "Error executing query: " . $conn->error
            ]);
        }
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Error preparing query: " . $conn->error
        ]);
    }
}
