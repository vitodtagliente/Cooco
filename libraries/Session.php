<?php

namespace Pure;

class Session {
	private static $session_string;

	static public function start( $security_string = "security_" ){
		session_start();
		self::$session_string = $security_string;
	}

	static public function set( $key, $value ){
		$key = self::$session_string . $key;
		$obj = $value;
		$obj = serialize( $value );
		$_SESSION[ $key ] = $obj;
	}

	static public function get( $key){
		$key = self::$session_string . $key;
		if( isset( $_SESSION[ $key ] ) ){
			$obj = $_SESSION[ $key ];
			return $obj = unserialize( $_SESSION[ $key ] );
		}
		else return null;
	}

	static public function exists( $key ){
		$key = self::$session_string . $key;
		return ( isset( $_SESSION[ $key ] ) );
	}

	static public function erase( $key ){
		$key = self::$session_string . $key;
		if( isset( $_SESSION[ $key ] ) )
			unset( $_SESSION[ $key ] );
	}

}

?>