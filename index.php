<?php

// Load vendor libraries
if( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	include_once( __DIR__ . '/vendor/autoload.php' );

// run the application
if(!isset($shell_mode))	$shell_mode = false;
if(!isset($argv)) $argv = array();
Pure\Application::execute(__DIR__, $shell_mode, $argv);

?>