<?php

$host = $_SERVER['HTTP_HOST']; // or $_SERVER['SERVER_NAME']


// //base url
// $host = $_SERVER['HTTP_HOST'];
// $isLocalhost = $host === 'localhost' || strpos($host, 'dev') !== false;
// $baseUrlClosure = $isLocalhost ? '\/anx7/' : '/';
// $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
// $base_url = $protocol . $_SERVER['HTTP_HOST'] . $baseUrlClosure ;
// $url = isset($_GET['url']) ? trim($_GET['url']) : '/';

// // Application urls
// $signatureBaseUrl = $base_url . 'services/uploadsSignatures/';
// $apiUrl = $base_url . 'services/api';

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';

$asset_base = $base_url == "http://localhost/"? '/MechXWeight/' : '/';

// Random const
$userID = '';
$userFullName = '';
$userFirstName = '';
$userLastName = '';
$userEmail = '';
$userPic = '';
$userCompany = '';
$userCompanyName = '';
$userRole = '';

function getBaseUrl(){
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';
    $asset_base = $base_url == "http://localhost/"? '/MechXWeight/' : '/';
    return '/MechXWeight/';
}
?>