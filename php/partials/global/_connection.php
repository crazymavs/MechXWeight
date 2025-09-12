<?php

// Get the current domain
$host = $_SERVER['HTTP_HOST']; // or $_SERVER['SERVER_NAME']

$db_host = "localhost";
$db_username = "MechXUser";
$db_password = "Tumb@T0oka123$";
$db_database = "MechXWeightDB";
$db_port = 3306;

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);

// Check connection
if ($conn->connect_error) {
    $response = array("status" => "error", "message" => "Registration failed. Please try again.");
    die("Connection failed: " . $conn->connect_error);
}

?>