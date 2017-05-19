<?php

require_once __DIR__ . '/boot.php';

// Load vendor libraries
if( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	include_once( __DIR__ . '/vendor/autoload.php' );

$app = new Pure\Application();
$app->loadRoutes();
$app->loadPackages();

$app->run();

?>
