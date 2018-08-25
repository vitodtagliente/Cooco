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

// set the config base directory
Pure\Config::path(__DIR__ . '/app/Config');

// start the session
Pure\Session::start(Pure\Config::get('app.security_string'));

// configure the auth interface
Pure\Auth::$class_name = Pure\Config::get('app.auth_class_name');

// prepare the database
Pure\ORM\Database::prepare(
	Pure\Config::get('database.type'),				// connector type
	Pure\Config::get('database.hostname'),			// hostname
	Pure\Config::get('database.name'),				// database
	Pure\Config::get('database.username'),			// username
	Pure\Config::get('database.password')			// password
);
// activate/deactivate debug mode
Pure\ORM\Database::main()->debug = config('app.debug_database_queries');

// run the application
if(!isset($shell_mode))	$shell_mode = false;
if(!isset($argv)) $argv = array();
Pure\Application::main()->run($shell_mode, $argv);

// close the database connection
Pure\ORM\Database::end();

?>
