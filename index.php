<?php

// Load vendor libraries
if( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	include_once( __DIR__ . '/vendor/autoload.php' );

require_once __DIR__ . '/config.php';

$app = new Pure\Application();
$app->loadRoutes();
$app->run();

?>
