<?php

namespace Pure;

class Url {

	private static $base = null;

	private function __construct(){}

	public static function base($value = null){
		if(isset($value))
            self::$base = $value;
        else {

        	if( empty(self::$base) )
            	self::$base = ( dirname( $_SERVER[ 'PHP_SELF' ] ) != '/' ) ? 
            		( dirname( $_SERVER[ 'PHP_SELF' ] ) ) : 
            		( '' );
        	return self::$base;
        
        }
	}

	public static function redirect( $url, $code = 302, $condition = true ){
        if ( !$condition )
            return;
        @header( "Location: {$url}", true, $code );
        exit;
    }

    public static function resource( $filename ){
    	return self::base() . "/public/$filename";
    }

	private function __destruct(){}

}

?>