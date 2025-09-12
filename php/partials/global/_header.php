<?php
include_once 'php/partials/global/_config.php';
$asset_base = getBaseUrl();

$loginName = $_SESSION['user_username'];
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];
$userLevel = $_SESSION['user_level'];

?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="<?= $asset_base; ?>" class="logo d-flex align-items-center">
    <img src="<?php echo $asset_base ?>assets/img/logo.png" alt="">
  </a>
  <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
  <i class="fa-duotone fa-solid fa-bars toggle-sidebar-btn"></i>

</div><!-- End Logo -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $userName ?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <div class="text-left"><strong><?php echo $loginName ?></div></strong>
        </li>
        <!-- <li>
          <hr class="dropdown-divider">
        </li> -->
        <li class="dropdown-header">
          <div><?php echo $userEmail ?></div>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li>
          <a class="dropdown-item d-flex align-items-center btnLogout" href="#">
          <i class="fa-solid fa-arrow-left-from-bracket"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->

