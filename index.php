<?php

// Load vendor libraries
if( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	include_once( __DIR__ . '/vendor/autoload.php' );

// TODO: TO BE MOVED
// register resource routes
function resource_routes($resource_base_url, $controller_class){
	router()->get("$resource_base_url/all", "$controller_class@all");
	router()->get($resource_base_url . '/show/$id', "$controller_class@show");
	router()->post("$resource_base_url/delete", "$controller_class@delete");
}

// run the application
if(!isset($shell_mode))	$shell_mode = false;
if(!isset($argv)) $argv = array();
Pure\Application::execute(__DIR__, $shell_mode, $argv);

?>