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
    case 'insertrecord':
        include_once 'php/partials/functions/_insertFirstWeight.php';
        return insertFirstWeight($conn, $data);
    case 'updatetransactionstatus':
        include_once 'php/partials/functions/_update_status.php';
        return updateRecordStatus($conn, $data);
    case 'getpendingtransactions':
        include_once 'php/partials/functions/_get_pending_transactions.php';
        return getPendingWeighingTransactions($conn, $data);
    case 'getalltransactions':
        include_once 'php/partials/functions/_get_all_transactions.php';
        return getAllWeighingRecords($conn, $data);
    case 'getcompletedtransactions':
        include_once 'php/partials/functions/_get_completed_transactions.php';
        return getCompletedWeighingTransactions($conn, $data);
    case 'getsinglerecordbyid':
        include_once 'php/partials/functions/_get_single_record.php';
        return getWeighingRecordById($conn, $data);
    case 'getallvehicles':
        include_once 'php/partials/functions/_get_all_vehicles.php';
        return getAllVehicles($conn, $data);
    case 'getvehiclebyid':
        include_once 'php/partials/functions/_get_all_vehicles.php';
        return getVehicleById($conn, $data);
    case 'insertvehicle':
        include_once 'php/partials/functions/_insert_vehicle.php';
        return insertVehicle($conn, $data);
    case 'getallparties':
        include_once 'php/partials/functions/_get_all_parties.php';
        return getAllParties($conn, $data);
    case 'getpartybyid':
        include_once 'php/partials/functions/_get_all_parties.php';
        return getPartyById($conn, $data);
    case 'insertparty':
        include_once 'php/partials/functions/_insert_party.php';
        return insertParty($conn, $data);
    case 'deleteparty':
        include_once 'php/partials/functions/_delete_party.php';
        return deletePartyById($conn, $data);
    case 'deletevehicle':
        include_once 'php/partials/functions/_delete_vehicle.php';
        return deleteVehicleById($conn, $data);
    case 'insertmaterial':
        include_once 'php/partials/functions/_insert_material.php';
        return insertMaterial($conn, $data);
    case 'getallmaterials':
        include_once 'php/partials/functions/_get_all_material.php';
        return getAllMaterials($conn, $data);
    case 'getmaterialbyid':
        include_once 'php/partials/functions/_get_all_material.php';
        return getMaterialById($conn, $data);
    case 'deletematerial':
        include_once 'php/partials/functions/_delete_material.php';
        return deleteMaterialById($conn, $data);
    case 'savelabelconfig':
        include_once 'php/partials/functions/_save_label_config.php';
        return save_label_config($conn, $data);
    case 'getlabelconfig':
        include_once 'php/partials/functions/_get_label_config.php';
        return get_label_config($conn, $data);
    case 'getrecordstatus':
        include_once 'php/partials/functions/_get_record_status.php';
        return getAllRecordStatuses($conn, $data);
    case 'getUsers':
        include_once 'php/partials/functions/_get_all_users.php';
        return getAllUsers($conn, $data);
    case 'get_user_types':
        include_once 'php/partials/functions/_get_user_types.php';
        return getUserTypes($conn);
    case 'saveuser':
        include_once 'php/partials/functions/_insert_user.php';
        return adduser($conn, $data);
    case 'deleteuser':
        include_once 'php/partials/functions/_delete_user.php';
        return deleteUser($conn, $data);
    default:
        echo json_encode([
            "status" => false,
            "message" => "Invalid request."
        ]);
        break;
}

$conn->close();
