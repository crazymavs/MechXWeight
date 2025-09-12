<?php
$breadcrumbs = [
    'dashboard' => '<li class="breadcrumb-item active">Dashboard</li>',
    'dashboardreport' => '<li class="breadcrumb-item active">Dashboard Report</li>',
    '/' => '<li class="breadcrumb-item active">Dashboard</li>',
    'tank1' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 1: Toluene</li>',
    'tank2' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 2: Butyl</li>',
    'tank3' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 3: 15001 MTO</li>',
    'tank4' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 4: 15002 MTO</li>',
    'tank5' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 5: 15003 MTO</li>',
    'tank6' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 6: : 15004 MTO</li>',
    'tank7' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 7: 15005 Toluene</li>',
    'tank8' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 8: 5001</li>',
    'tank9' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 9: 5002</li>',
    'tank10' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 10: 5003</li>',
    'tank11' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 11: 5004</li>',
    'tank12' => '<li class="breadcrumb-item active">Tanks</li><li class="breadcrumb-item active">Tank 12: 5005</li>',
    'reports/newsolventyard' => '<li class="breadcrumb-item active">Reports</li><li class="breadcrumb-item active">New Solvent Yard Report</li>',
    'reports/oldsolventyard' => '<li class="breadcrumb-item active">Reports</li><li class="breadcrumb-item active">Old Solvent Yard Report</li>',
    'reports/resin' => '<li class="breadcrumb-item active">Reports</li><li class="breadcrumb-item active">Resin Report</li>',
    'reports' => '<li class="breadcrumb-item active">Reports</li>',
    'users' => '<li class="breadcrumb-item active">Users</li>',
    'userprofile' => '<li class="breadcrumb-item active">User Profile</li>',
    'usermanagement' => '<li class="breadcrumb-item active">User Management</li>',
    'useraccess' => '<li class="breadcrumb-item active">User Access Control</li>',
	'dashboardsettings' => '<li class="breadcrumb-item active">Dashboard Settings</li>',
	'faq' => '<li class="breadcrumb-item active">F.A.Q</li>',
	'ftmlive' => '<li class="breadcrumb-item active">Flow Meters Live</li>',
	'batches' => '<li class="breadcrumb-item active">Batches</li>',
];

$pageName = [
    'dashboard' => 'Dashboard',
    '/' => 'Dashboard',
    'dashboardreport' => 'Dashboard Report',
    'tank1' => 'Tank 1: Toluene',
    'tank2' => 'Tank 2: Butyl',
    'tank3' => 'Tank 3: 15001 MTO',
    'tank4' => 'Tank 4: 15002 MTO',
    'tank5' => 'Tank 5: 15003 MTO',
    'tank6' => 'Tank 6: : 15004 MTO',
    'tank7' => 'Tank 7: 15005 Toluene',
    'tank8' => 'Tank 8: 5001',
    'tank9' => 'Tank 9: 5002',
    'tank10' => 'Tank 10: 5003',
    'tank11' => 'Tank 11: 5004',
    'tank12' => 'Tank 12: 5005',
    'reports/newsolventyard' => 'New Solvent Yard Report',
    'reports/oldsolventyard' => 'Old Solvent Yard Report',
    'reports/resin' => 'Resin Report',
    'reports' => 'Reports',
    'users' => 'Users',
    'userprofile' => 'User Profile',
    'usermanagement' => 'User Management',
    'useraccess' => 'User Access Control',
	'dashboardsettings' => 'Dashboard Settings',
	'faq' => 'Frequently asked questions',
	'ftmlive' => 'Flow Meters - Live',
	'batches' => 'Batches</li>',
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