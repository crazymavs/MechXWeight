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


  <nav class="header-nav ms-auto d-flex gap-4">
    <div class="ms-auto d-flex align-items-center gap-2">
      <div class="company_logo">
        <img src="<?= $asset_base ?>/assets/img/logo_2x.png" alt="">
      </div>
      <div class="d-flex flex-column">
        <p class=" m-0 company_title">CompanyName</p>
        <p class="m-0 company_addr">CompanyName</p>
      </div>
    </div>

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
<style>
  .company_title {
    font-weight: 600;
  }

  .company_addr {
    font-size: 10px;
  }

  .company_logo {
    width: 24px;
    height: 24px;
  }

  .company_logo img {
    width: 100%;
    height: 100%;
  }
</style>

<script>
  async function getCompData() {
    const userid = <?= $_SESSION['user_id'] ?? 0 ?>;
    const companyid = <?= $_SESSION['user_company'] ?? 0 ?>;

    const res = await getUserCompany({
      user_id: userid,
      company_id: companyid
    })
    let company = null;
    if (res.status) {
      if (Array.isArray(res.data)) {
        company = res.data[0] || null; // first company from list
      } else {
        company = res.data; // single company object
      }
    }

    if (company) {
      currentCompany = company
      document.querySelector('.company_title').innerText = company.company_name
      document.querySelector('.company_addr').innerText = company.company_addr
      if (company.company_logo) {
        document.querySelector('.company_logo img').src = '<?= $asset_base ?>' + company.company_logo
      }

    } else {
      console.warn('No company data to fill form');
    }
    console.log(company)

  }
  getCompData()
</script>