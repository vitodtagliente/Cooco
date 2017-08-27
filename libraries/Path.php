<?php

namespace Pure;

class Path {

	private function __construct(){

	}

	private static $root;
	private static $resources;
    private static $routes;

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

    public static function routes($value = null){
        if(isset($value))
            self::$routes = $value;
        else return self::$routes;
    }

	private function __destruct(){

	}

}

?>
