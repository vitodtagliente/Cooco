<?php

require_once __DIR__ . '/boot.php';

// Load vendor libraries
if( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	include_once( __DIR__ . '/vendor/autoload.php' );

$app = new Pure\Application();
$router = $app->router();

include_once __DIR__ . '/routes/web.php';

$app->run();

?>
