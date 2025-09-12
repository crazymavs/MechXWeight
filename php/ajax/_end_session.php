<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function logoutSession(){
    // session_destroy();
    if (session_destroy()) {
        echo json_encode([
            "status" => "success",
            "message" => "Logout successful",
            "redirect" => "login" // optional
        ]);
    }else {
        echo json_encode([
            "status" => "failure",
            "message" => "Logout unsuccessful",
            "redirect" => "" // optional
        ]);
    }
    // echo 'success';
}
?>