<?php

require_once __DIR__ . '/libraries/Route.php';
require_once __DIR__ . '/libraries/Router.php';
require_once __DIR__ . '/libraries/Controller.php';
require_once __DIR__ . '/libraries/View.php';

$router = new Pure\Router();

include_once __DIR__ . '/config.php';
include_once __DIR__ . '/routes/web.php';

$router->dispatch();

?>
