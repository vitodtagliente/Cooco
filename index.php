<?php

require_once __DIR__ . '/boot.php';

$app = new Pure\Application();
$router = $app->router();

include_once __DIR__ . '/routes/web.php';

$app->run();

?>
