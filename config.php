<?php

/*
	--------------------------------------
			Session Configuration
	--------------------------------------
*/

session_start();
Pure\Session::config( 'pure.session.' );

/*
	--------------------------------------
			Database Configuration
	--------------------------------------
*/

Pure\Database::prepare(
	'mysql',				// connector type
	'locahost',				// hostname
	'pure',					// database
	'root',					// username
	'root'					// password
);

/*
	--------------------------------------
			Paths Configuration
	--------------------------------------
*/

Pure\Path::root( __DIR__ );
Pure\Path::routes( __DIR__ . '/routes' );
Pure\Path::resources( __DIR__ . '/public' );
Pure\Path::packages( __DIR__ . '/packages' );

Pure\Route::path( __DIR__ . '/app/controllers' );

Pure\View::path( __DIR__ . '/app/views' );

/*
    --------------------------------------
			Custom Configuration
	--------------------------------------
*/

?>
