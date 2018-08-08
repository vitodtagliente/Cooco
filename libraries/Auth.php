<?php

namespace Pure;

class Auth
{
	private function __construct(){}
	private function __destruct(){}

	public static $class_name = null;
	private static $session_key = 'user';

	public static function check(){
		return Session::exists(self::$session_key);
	}

	public static function user(){
		return Session::get(self::$session_key);
	}

	public static function authenticate($condition, $remember = false){
		if(!empty(self::$class_name) && class_exists(self::$class_name))
		{
			// UserModelClass:find($condition)
			$user = call_user_func(self::$class_name . '::find', $condition);
			if($user)
			{
				Session::set(self::$session_key, $user);
				return true;
			}
		}
		return false;
	}

	public static function logout(){
		Session::erase(self::$session_key);
	}
}

?>
