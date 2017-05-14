<?php

namespace Pure;

class Path {

	private function __construct(){

	}

	private static $root;
	private static $resources;

	public static function root($value = null){
        if(isset($value))
            self::$root = $value;
        else return self::$root;
    }

    public static function resources($value = null){
        if(isset($value))
            self::$resources = $value;
        else return self::$resources;
    } 


	private function __destruct(){

	}

}

?>