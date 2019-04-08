<?php

// Database configuration

return array(
	
	// which database is active
	'active' => 'dev',

	// development database
	'dev' => [
		'type' => 'mysql',
		'host' => 'localhost',
		'name' => 'pure',
		'username' => 'root',
		'password' => ''
	],

	// production database
	'production' => [
		'type' => 'mysql',
		'host' => 'localhost',
		'name' => 'pure',
		'username' => 'root',
		'password' => ''
	],

	// Enable to show database queries in debug mode
	// 'debug_database_queries' => false
	'debug_queries' => false
);

?>