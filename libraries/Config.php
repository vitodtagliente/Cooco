<?php

namespace Pure;

class Config
{
	private function __construct(){}
	private function __destruct(){}

	private static $base_path = null;

	// configs caching
	private static $configs = array();

	public static function path($path){
		self::$base_path = $path;
	}

	// retrieve a config option
	public static function get($option_name)
	{
		$parts = explode('.', $option_name);
		if(count($parts) > 1)
		{
			$config_name = $parts[0];
			if (strpos($config_name, '/') !== false) {
		    	// it is an absolute path
			} 
			// it is a relative path
			else $config_name = self::$base_path . '/' . $config_name;

			if(!array_key_exists($config_name, self::$configs))
			{
				self::$configs[$config_name] = parse_ini_file($config_name . '.ini');
			}

			if(array_key_exists($parts[1], self::$configs[$config_name]))
				return self::$configs[$config_name][$parts[1]];
		}
		return null;
	}
}

?>