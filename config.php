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

Pure\ORM\Database::prepare(
	'mysql',				// connector type
	'localhost',			// hostname
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

// Set the path in which find application views
Pure\Template\View::path( __DIR__ . '/app/views' );

/*
    --------------------------------------
			Custom Configuration
	--------------------------------------
*/

// TODO

?>
