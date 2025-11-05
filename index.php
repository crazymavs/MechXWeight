<?php

// header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

session_start();
$isLoggedIn = false;
$loginName = $_SESSION['user_username'];
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];
$userLevel = $_SESSION['user_level'];
$userType = $_SESSION['user_type'];
$userCompany = $_SESSION['user_company'];

// Set timezone to India Standard Time
date_default_timezone_set('Asia/Kolkata');


$url = isset($_GET['url']) ? trim($_GET['url']) : '/';

// $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
// $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';

// $asset_base = $base_url == "http://localhost:8080/"? '/MechXWeight/' : '/';

// OR

// $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
// $host = $_SERVER['HTTP_HOST'];

// Always get the root of your app
$project_root = '/MechXWeight'; // <-- Change this ONLY if the folder name changes
$base_url = $protocol . $host . $project_root . '/';
$asset_base = $project_root . '/'; // For linking to /MechXWeight/assets/


// $asset_base = "http://localhost:8080/MechXWeight/";

// Set session timeout to 30 minutes (1800 seconds)
$timeout = 30 * 60; // 30 minutes in seconds
session_set_cookie_params($timeout);



$routes = [
	'' => 'php/views/_login.php',
	'/' => 'php/views/_login.php',
	'login' => 'php/views/_login.php',
	'api' => 'php/ajax/_mechxweightapi.php',
	'error' => 'php/views/_error.php',
	'dashboard' => 'php/views/_dashboard.php',
	'labelconfig' => 'php/views/_labelconfig.php',
	'usermanagement' => 'php/partials/_userManagement.php',
	'companyconfig' => 'php/views/_company_config.php',
	'editor' => 'php/views/_timy_mc_editor.php',
	'register' => 'php/views/_register.php',
	'bill' => 'php/views/_bill_template.php',
	'regcompany' => 'php/views/_register_company.php',
];

// $isLoggedIn = true;
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
if ($isLoggedIn) {
	$loginName = $_SESSION['user_username'];
	$user_id = $_SESSION['user_id'];
	$userName = $_SESSION['user_name'];
	$userEmail = $_SESSION['user_email'];
	$userLevel = $_SESSION['user_level'];
	$userType = $_SESSION['user_type'];
	$userCompany = $_SESSION['user_company'];
}


if ($url == 'bill') {
	include_once $routes['bill'];
	return;
}

if ($url == 'api') {
	include_once $routes['api'];
	return;
}

function loadPage()
{
	global $url, $routes;
	$parts = explode('/', $url);
	$firstElement = $parts[0];
	$pageExists = array_key_exists($firstElement, $routes);
	if ($pageExists) {

		include_once 'php/partials/global/_header.php';
		echo '<main id="main" class="main">';
		include_once('php/partials/_sidebar.php');
		// include_once('php/partials/_dashboardTitle.php');
		include_once $routes[$firstElement];
		echo '</main>';
		include_once 'php/partials/global/_footer.php';
	}
	return $pageExists;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Mecho-Tronix Weighing Solutions</title>
	<meta name="author" content="Digitelligence Technologies Pvt. Ltd.">
	<meta name="description"
		content="A complete dashboard to see daily activities, generate reports and manage users">
	<meta name="keywords" content="" />
	<meta name="robots" content="NOINDEX,NOFOLLOW">
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicons - Place favicon.ico in the root directory -->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $asset_base ?>assets/img/favicons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $asset_base ?>assets/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $asset_base ?>assets/img/favicons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $asset_base ?>assets/img/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php echo $asset_base ?>assets/img/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $asset_base ?>assets/img/favicons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<!--==============================
	    All CSS File
	============================== -->
	<link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/inriasans.css">
	<!-- Bootstrap -->
	<!-- <link rel="stylesheet" href="assets/css/app.min.css"> -->
	<link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/bootstrap.min.css">
	<!-- Fontawesome Icon -->
	<!-- <link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/fontawesome.min.css"> -->
	<link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/font-awesome.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/magnific-popup.min.css">
	<!-- Slick Slider -->
	<link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/slick.min.css">
	<!-- Data tables -->
	<link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/datatables.css">
	<!-- Custom Phone Number Input -->
	<!-- <link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/intlTelInput.css"> -->
	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo $asset_base ?>assets/css/adminStyle.css">
	<script src="<?php echo $asset_base ?>assets/js/apiService.js"></script>
	<!-- Datatable File -->
	<script src="<?php echo $asset_base ?>assets/js/simple-datatables.js"></script>
</head>

<body>
	<script>
		const ajaxBase = "<?php echo $asset_base ?>";
		const currentPage = '<?= $url; ?>';
		const apiBase = "<?php echo $asset_base ?>api";
	</script>
	<?php
	// Check if the requested URL exists in the routes
	switch ($url) {
		case '/':
		case ',':
		case 'login':
			global $routes;
			$pageExists = array_key_exists($url, $routes);

			if ($isLoggedIn) {
				// Redirect logged-in users to dashboard
				header("Location: " . $asset_base . "dashboard");
				exit(); // Important: Stop further script execution
			} else {
				// Show login page
				if ($pageExists) {
					// header("Location: " . $asset_base . "login");
					// exit(); 
					include_once $routes['login'];
				} else {
					http_response_code(404);
				}
			}
			break;
		case 'register':
			global $routes;
			$pageExists = array_key_exists($url, $routes);
			if ($isLoggedIn) {
				// Redirect logged-in users to dashboard
				header("Location: " . $asset_base . "dashboard");
				exit(); // Important: Stop further script execution
			} else {
				// Show register page
				if ($pageExists) {
					include_once $routes['register'];
				} else {
					http_response_code(404);
				}
			}
			break;
		case 'regcompany':
			global $routes;
			$pageExists = array_key_exists($url, $routes);
			if (!$isLoggedIn) {
				// Redirect non-logged-in users to login
				header("Location: " . $asset_base . "login");
				exit();
			} else {
				if ($userCompany != 0) {
					// Redirect logged-in users to dashboard
					header("Location: " . $asset_base . "dashboard");
					exit(); // Important: Stop further script execution
				} else {
					// Show login page
					if ($pageExists) {
						// header("Location: " . $asset_base . "login");
						// exit(); 
						include_once $routes['regcompany'];
					} else {
						http_response_code(404);
					}
				}
			}
			break;

		case 'api':
			include_once $routes['api'];
			break;

		case 'error':
			include_once $routes['error'];
			break;

		default:

			if (!$isLoggedIn) {
				// Redirect non-logged-in users to login
				header("Location: " . $asset_base . "login");
				exit();
			} else {
				// Load the requested page or show error
				if (!loadPage()) {
					http_response_code(404);
					// echo '404 Not Found: ' . htmlspecialchars($url);
					include_once 'php/views/_error.php';
				}
			}
			break;
	}


	?>


	<div class="toast-container position-fixed top-0 end-0 p-3">
		<div id="successToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<strong class="me-auto">Success</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="success-toast-body toast-body">

			</div>
		</div>

		<div id="errorToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-header">
				<strong class="me-auto">Error</strong>
				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="error-toast-body toast-body">

			</div>
		</div>
	</div>


	<?php if ($url !== '/' && $url !== 'login'): ?>


		<div class="loadingDiv text-center d-none">
			<div class="spinner-border nerolac text-danger" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
			<div class="text-danger loadingSpace">
				<h1>Loading...</h1>
			</div>
			<div class="spinner-border digi text-danger" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
	<?php endif; ?>
	<!--==============================
        All Js File
    ============================== -->

	<!-- Jquery -->
	<script src="<?php echo $asset_base ?>assets/js/jquery-3.6.0.min.js"></script>
	<!-- Slick Slider -->
	<script src="<?php echo $asset_base ?>assets/js/slick.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo $asset_base ?>assets/js/bootstrap.bundle.js"></script>
	<!-- Lazy loader -->
	<script src="<?php echo $asset_base ?>assets/js/jquery.lazy.min.js"></script>
	<!-- WOW.js Animation -->
	<script src="<?php echo $asset_base ?>assets/js/wow.min.js"></script>
	<!-- Magnific Popup -->
	<script src="<?php echo $asset_base ?>assets/js/jquery.magnific-popup.min.js"></script>
	<!-- Isotope Filter -->
	<script src="<?php echo $asset_base ?>assets/js/imagesloaded.pkgd.min.js"></script>
	<script src="<?php echo $asset_base ?>assets/js/isotope.pkgd.min.js"></script>
	<!-- Custom Phone Number Input -->
	<script src="<?php echo $asset_base ?>assets/js/intlTelInput.min.js"></script>
	<!-- form handler Js File -->
	<script src="<?php echo $asset_base ?>assets/js/form_handler.js"></script>

	<!-- tinymce File -->
	<script src="<?php echo $asset_base ?>assets/js/tinymce.min.js"></script>
	<!-- Excel Expor -->
	<script src="<?php echo $asset_base ?>assets/js/excelexportjs.js"></script>
	<!-- Exccel Import -->
	<script src="<?php echo $asset_base ?>assets/js/xlsx.full.min.js"></script>

	<script src="<?php echo $asset_base ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
	<script src="<?php echo $asset_base ?>assets/vendor/chart.js/chart.umd.js"></script>
	<script src="<?php echo $asset_base ?>assets/vendor/echarts/echarts.min.js"></script>
	<script src="<?php echo $asset_base ?>assets/vendor/quill/quill.js"></script>
	<script src="<?php echo $asset_base ?>assets/js/adminMain.js"></script>
	<script src="<?php echo $asset_base ?>assets/js/admin.js"></script>
	<?php if ($url === '/' || $url === 'login'): ?>
		<script src="<?php echo $asset_base ?>assets/js/login.js"></script>
	<?php endif; ?>
	<?php if ($url === 'usermanagement'): ?>
		<script src="<?php echo $asset_base ?>assets/js/userMgt.js"></script>
	<?php endif; ?>
	<?php if ($url === 'userprofile'): ?>
		<script src="<?php echo $asset_base ?>assets/js/user.js"></script>
	<?php endif; ?>
</body>

</html>