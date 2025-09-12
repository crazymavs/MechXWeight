<?php
//Login handler
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function loginSession($conn){
    // Receive POST inputs
$identifier = $_POST['user_identifier'];
$password = $_POST['user_password'];

// Sanitize inputs
$identifier = mysqli_real_escape_string($conn, $identifier);

// Prepare SQL
$sql = "SELECT * FROM users 
        WHERE (user_username = ? OR user_email = ?) 
          AND user_is_active = 1 
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $identifier, $identifier);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Verify password
    if (password_verify($password, $user['user_password'])) {

        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_username'] = $user['user_username'];
        $_SESSION['user_level'] = $user['user_is_admin'] == 1 ? 'admin' : 'user';

        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "redirect" => "dashboard" // optional
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


?>