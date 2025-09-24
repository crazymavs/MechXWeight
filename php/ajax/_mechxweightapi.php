<?php

// if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
//     echo 'Not a valid server request';
//     return;
// }

session_start();
// $_SESSION['userID'] = "";

include_once "php/partials/global/_connection.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    include_once 'php/views/_error.php';
    return;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);

include('php/global/_helper.php');
include('php/global/_connection.php');

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if (strpos($contentType, 'application/json') !== false) {
    // Handle JSON data
    $data = json_decode(file_get_contents("php://input"), true);
} elseif (strpos($contentType, 'multipart/form-data') !== false) {
    // Handle FormData (multipart/form-data)
    $data = $_POST;  // All non-file data
    $files = $_FILES;  // All files

    // Example of how to access the uploaded file:
    if (isset($files['sealSignature']) && $files['sealSignature']['error'] === UPLOAD_ERR_OK) {
        $file = $files['sealSignature'];
        $fileName = $file['name'];


        // You can now move or process the file as needed.
    }
} else {
    echo json_encode(["status" => false, "message" => "Invalid request format."]);
    return;
}
// $data = json_decode(file_get_contents("php://input"), true);

// echo json_encode($data);
$action_method = $data['actionMethod'] ?? null;
switch ($action_method) {
    case 'addfirstweight':
        include_once 'php/partials/functions/_insertFirstWeight.php';
        return insertFirstWeight($conn, $data);
    case 'getPendingWeights':
        include_once 'php/partials/functions/_get_pending_records.php';
        return getPendingWeighingRecords($conn, $data);
    case 'getsinglerecordbyid':
        include_once 'php/partials/functions/_get_single_record.php';
        return getWeighingRecordById($conn, $data);
    case 'getallvehicles':
        include_once 'php/partials/functions/_get_all_vehicles.php';
        return getAllVehicles($conn, $data);
    case 'insertvehicle':
        include_once 'php/partials/functions/_insert_vehicle.php';
        return insertVehicle($conn, $data);
    case 'getallparties':
        include_once 'php/partials/functions/_get_all_parties.php';
        return getAllParties($conn, $data);
    case 'insertparty':
        include_once 'php/partials/functions/_insert_party.php';
        return insertParty($conn, $data);
    case 'deleteparty':
        include_once 'php/partials/functions/_delete_party.php';
        return deletePartyById($conn, $data);
    case 'deletevehicle':
        include_once 'php/partials/functions/_delete_vehicle.php';
        return deleteVehicleById($conn, $data);
    default:
        echo json_encode([
            "status" => false,
            "message" => "Invalid request."
        ]);
        break;
}

$conn->close();
