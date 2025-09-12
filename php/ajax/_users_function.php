<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function userFetching($conn){
    $sql = "SELECT * FROM users ORDER BY user_created_at";
    $result = mysqli_query($conn, $sql);
    
    $users = [];
    $slno = 1;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = [
            'slno' => $slno++,
            'userid' => $row['user_id'],
            'name' => $row['user_name'],
            'username' => $row['user_username'] ?? '',
            'email' => $row['user_email'],
            'type' => $row['user_is_admin'] == 1 ? 'Admin' : 'User',
            'status' => $row['user_is_active'] == 1 ? 'Active' : 'Inactive',
            'created' => date('d-m-Y H:i', strtotime($row['user_created_at']))
        ];
    }
    
    echo json_encode($users);
}


function createUser($conn){

    extract($_POST);
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Prepare insert query
    $sql = "INSERT INTO users (
        user_name, 
        user_username, 
        user_email, 
        user_password, 
        user_is_admin, 
        user_is_active, 
        user_created_at
    ) VALUES (?, ?, ?, ?, ?, 1, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", 
        $user_name, 
        $user_username, 
        $user_email, 
        $hashed_password, 
        $user_is_admin, 
    );

    try{
        // $stmt->execute();
        if ($stmt->execute()) {
            echo json_encode(array(
                'status' => true,
                'message' => "User added successfully."
            ));
        }
    }catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            echo json_encode(["status" => false, "message" => "Username or Email already exists."]);
            return;
        } else {
            echo json_encode(["status" => false, "message" => "Database error: " . $e->getMessage()]);
            return;
        }
    }

    $stmt->close();
}

function editUser($conn){
    extract($_POST);

    if ($user_id && $user_name && $user_email) {
        $sql = "UPDATE users SET user_name = '$user_name', user_is_admin = $user_is_admin, user_is_active = $user_is_active";
        if (!empty($user_password)) {
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            $sql .= ", user_password='$hashed_password'";
        }
        $sql .= " WHERE user_id=$user_id AND user_email = '$user_email'";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array(
                'status' => true,
                'message' => "User updated successfully."
            ));
        } else {
            echo json_encode(array(
                'status' => false,
                'message' => "Unable to update."
            ));
        }
    } else {
        echo json_encode(array(
            'status' => false,
            'message' => "Unable to update."
        ));
    }
}

function deleteUser($conn){
    extract($_POST);

    if ($user_email) {
        if(mysqli_query($conn, "DELETE FROM users WHERE user_email = '$user_email'")){
            echo json_encode(array(
                'status' => true,
                'message' => "User $user_name with email id: $user_email, deleted successfully."
            ));
        }else {
            echo json_encode(array(
                'status' => false,
                'message' => "Unable to delete. Try again later."
            ));
        }
    }
}

function changePassword($conn){
    extract($_POST);
    $userEmail = $_SESSION['user_email'];  // or however you identify the user
    if (!$current_password || !$new_password) {
        echo json_encode(array(
            'status' => false,
            'message' => "Missing Inputs"
        ));
        return;
    }
    $query = "SELECT user_password FROM users WHERE user_email = ?";
    $stmt  = $conn->prepare($query);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $stmt->bind_result($hashed);
    $stmt->fetch();
    $stmt->close();

    if (!$hashed || !password_verify($current_password, $hashed)) {
        echo json_encode(array(
            'status' => false,
            'message' => "Incorrect passowrd!"
        ));
        return;
    }
    $newHash = password_hash($new_password, PASSWORD_DEFAULT);
    $update  = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
    $update->bind_param("ss", $newHash, $userEmail);

    if ($update->execute()) {
        echo json_encode(array(
            'status' => true,
            'message' => "Password changed successfully."
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'message' => "Could not update passowrd!"
        ));
    }
}

?>