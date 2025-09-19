<?php
$routes = [
    '' => 'php/partials/_dashboard.php',
    'pending' => 'php/partials/_pending_dashboard.php',
    'login' => 'php/views/_login.php',
    'api' => 'php/ajax/_mechxweightapi.php',
    'error' => 'php/views/_error.php',
    'dashboard' => 'php/views/_dashboard.php',

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