<?php
$routes = [
    '' => 'php/partials/_dashboard.php',
    'pendingtransactions' => 'php/partials/dashboard/_pending_dashboard.php',
    'alltransactions' => 'php/partials/dashboard/_pending_dashboard.php',
    'completedtransactions' => 'php/partials/dashboard/_pending_dashboard.php',
    'vehicles' => 'php/partials/dashboard/_vehicle_master_table.php',
    'parties' => 'php/partials/dashboard/_parties_master_table.php',
    'materials' => 'php/partials/dashboard/_material_master_table.php',


];
$parts = explode('/', $url);
$subRoute = $parts[1];
include_once $routes[$subRoute];
?>
<section>
    <? $parts = explode('/', $url);
    $subRoute = $parts[1];

    echo $subRoute;
    ?>

</section>