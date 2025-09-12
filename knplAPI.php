<?php

session_start();

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Get action method for functionality
$action_method = $_POST['action_method'];

// echo json_encode(array(
//     'status' => true,
//     'message' => $action_method
// ));
// return;

// Access database configuration
require_once 'php/partials/global/_dbConfig.php';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

switch ($action_method) {
    case 'createUser':
        include_once 'php/ajax/_users_function.php';
        return createUser($conn);
        break;
    case 'editUser':
        include_once 'php/ajax/_users_function.php';
        return editUser($conn);
        break;
    case 'deleteUser':
        include_once 'php/ajax/_users_function.php';
        return deleteUser($conn);
        break;        
    case 'login':
        include_once 'php/ajax/_login_get.php';
        return loginSession($conn);
        break;
    case 'changePassword':
        include_once 'php/ajax/_users_function.php';
        return changePassword($conn);
        break;
    case 'getUsers':
        include_once 'php/ajax/_users_function.php';
        return userFetching($conn);
        break;   
    case 'logout':
        include_once 'php/ajax/_end_session.php';
        return logoutSession();
        break;   
    case 'dashGraphData':
        include_once 'php/ajax/_dashboardGraph.php';
        return getDashboardGraphData($conn);
        break;
    case 'getReportData' :
        include_once 'php/ajax/_getReportsData.php';
        return getReportsData($conn);
        break;
    case 'getAllTanksDashboardData':
        include_once 'php/ajax/_getReportsData.php';
        return getAllTanksData($conn);
        break;
    case 'driveGain':
        include_once 'php/ajax/_getReportsData.php';
        return getAllFTM($conn);
        break;
    case 'getBatches':
        include_once 'php/ajax/_getReportsData.php';
        return getFlowBatches($conn);
        break;
    
    default:
        # code...
        break;
}

// Close database connection
$conn->close();

?>