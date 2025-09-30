  <?php

    include_once 'php/partials/global/_config.php';
    $asset_base = getBaseUrl();
    ?>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">
          <li class="nav-item">
              <a class="nav-link collapsed" href="<?php echo $asset_base ?>dashboard">
                  <i class="fa-duotone fa-solid fa-gauge-max"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->


          <li>
              <hr>
          </li>

          <li class="nav-heading"><i class="fa-duotone fa-solid fa-scale-balanced"></i> <span>Weighments</span></li>
          <li class="nav-item">
              <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#" aria-expanded="true">
                  <i class="fa-solid fa-folder-tree"></i><span>Masters</span><i class="fa fa-angle-down ms-auto" aria-hidden="true"></i>
              </a>
              <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="<?php echo $asset_base ?>dashboard/vehicles">
                          <i class=" fa-solid fa-truck"></i><span>Vehicle</span>
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo $asset_base ?>dashboard/parties">
                          <i class="fa-solid fa-users"></i><span>Parties</span>
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo $asset_base ?>dashboard/materials">
                          <i class="fa-solid fa-box-open"></i><span>Material</span>
                      </a>
                  </li>

              </ul>
          </li>
          <li class="nav-item">
              <a class="nav-link collapsed" href="<?php echo $asset_base ?>dashboard/pending">
                  <i class="fa-solid fa-list-radio"></i>
                  <span>Transactions</span>
              </a>
          </li><!-- End New Solvent Yard -->
          <li class="nav-item">
              <a class="nav-link collapsed" href="<?php echo $asset_base ?>reports/oldsolventyard">
                  <i class="fa-duotone fa-solid fa-scale-balanced"></i>
                  <span>Users</span>
              </a>

          <li>
              <hr>
          </li>



          <?php if (isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'admin') : ?>
              <li class="nav-heading">
                  <i class="fa-duotone fa-light fa-arrows-down-to-people"></i>
                  <span>Admin</span>
              </li>

              <li class="nav-item">
                  <a class="nav-link collapsed" href="<?= $asset_base ?>usermanagement">
                      <i class="fa-duotone fa-solid fa-users"></i>
                      <span>Users Management</span>
                  </a>
              </li>

              <li class="nav-item disabled">
                  <div class="nav-link collapsed">
                      <i class="fa-duotone fa-solid fa-person-circle-check"></i>
                      <span>Users Access Control</span>
                  </div>
              </li>

              <li class="nav-item disabled">
                  <div class="nav-link collapsed">
                      <i class="fa-duotone fa-solid fa-envelope"></i>
                      <span>Report Email Settings</span>
                  </div>
              </li>

              <li class="nav-item disabled">
                  <div class="nav-link collapsed">
                      <i class="fa-duotone fa-solid fa-envelope"></i>
                      <span>SMS Settings</span>
                  </div>
              </li>

              <li>
                  <hr>
              </li>
          <?php endif; ?>




          <li class="nav-item">
              <a class="nav-link collapsed" href="<?php echo $asset_base ?>userprofile">
                  <i class="fa-duotone fa-solid fa-user-gear"></i>
                  <span>Profile Settings</span>
              </a>
          </li><!-- End Profile Settings -->

          <li>
              <hr>
          </li>

          <li class="nav-item">
              <a class="nav-link collapsed" href="<?php echo $asset_base ?>faq">
                  <i class="fa-duotone fa-solid fa-comments-question"></i>
                  <span>F.A.Q</span>
              </a>
          </li><!-- End FAQ List -->

          <li>
              <hr>
          </li>

          <li class="nav-item">
              <a class="nav-link collapsed btnLogout" href="<?php echo $asset_base ?>">
                  <i class="fa-duotone fa-solid fa-arrow-left-from-bracket"></i>
                  <span>Sign out</span>
              </a>
          </li><!-- End Register Page Nav -->
      </ul>

  </aside><!-- End Sidebar-->