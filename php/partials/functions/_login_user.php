<?php
function loginUser($conn, $data)
{
    $identifier = isset($data['user_identifier']) ? $data['user_identifier'] : '';
    $password = isset($data['user_password']) ? $data['user_password'] : '';

    // Sanitize identifier input
    $identifier = $conn->real_escape_string($identifier);

    $sql = "SELECT * FROM users 
        WHERE (user_username = ? OR user_email = ?)
        AND user_is_active = 1
        LIMIT 1";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo json_encode([
            "status" => "error",
            "message" => "Database error (prepare failed)"
        ]);
        return;
    }

    // Bind parameters
    $stmt->bind_param("ss", $identifier, $identifier);

    // Execute
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['user_password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['user_email'] = $user['user_email'];
            $_SESSION['user_username'] = $user['user_username'];
            $_SESSION['user_level'] = $user['user_is_admin'] == 1 ? 'admin' : 'user';
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['user_company'] = $user['user_company'];
            echo json_encode([
                "status" => "success",
                "message" => "Login successful",
                "redirect" => "dashboard"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid password"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "User not found or inactive"
        ]);
    }

    mysqli_stmt_close($stmt);
}
