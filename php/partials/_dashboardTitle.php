<?php
$breadcrumbs = [
    'dashboard' => '<li class="breadcrumb-item active">Dashboard</li>',
    '/' => '<li class="breadcrumb-item active">Dashboard</li>',
    'users' => '<li class="breadcrumb-item active">Users</li>',
    'userprofile' => '<li class="breadcrumb-item active">User Profile</li>',
    'usermanagement' => '<li class="breadcrumb-item active">User Management</li>',
    'useraccess' => '<li class="breadcrumb-item active">User Access Control</li>',
    'dashboardsettings' => '<li class="breadcrumb-item active">Dashboard Settings</li>',
    'faq' => '<li class="breadcrumb-item active">F.A.Q</li>',
];

$pageName = [
    'dashboard' => 'Dashboard',
    '/' => 'Dashboard',
    'users' => 'Users',
    'userprofile' => 'User Profile',
    'usermanagement' => 'User Management',
    'useraccess' => 'User Access Control',
    'dashboardsettings' => 'Dashboard Settings',
];

?>
<div class="pagetitle">
    <h1>
        <?php
        if (array_key_exists($url, $routes)) {
            echo $pageName[$url];
        }
        ?>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $asset_base ?>">Home</a></li>
            <?php
            if (array_key_exists($url, $routes)) {
                echo $breadcrumbs[$url];
            }
            ?>
        </ol>
    </nav>
</div><!-- End Page Title -->