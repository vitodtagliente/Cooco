<?php

use Pure\CLI\Command;

class app extends Command {

	function session( $value = null ){
		$content = file_get_contents( Pure\Path::root() . '/config.php' );
		if( empty( $content ) ){
			echo "\nCannot configure the session string\n\n";
			return;
		}

		$replacement = null;
		$current_value = null;
		if( strpos($content, 'Session::') !== false ){
			foreach ($this->findRules($content, 'Session::', ');') as $rule) {
				$replacement = $rule;
				break;
			}
		}

		if( empty( $replacement ) ){
			echo "\nCannot configure the session string\n\n";
			return;
		} 
		else {
			foreach ($this->findRules($replacement, '(', ')') as $rule) {
				$current_value = $rule;
				$current_value = ltrim($current_value, '(');
				$current_value = rtrim($current_value, ')');
				$current_value = trim($current_value);
				$current_value = trim($current_value, "'");
				$current_value = trim($current_value, '"');
				break;
			}
		}

		if( $value == null ){
			echo "\nThe current session string is: $current_value\n\n";
		}
		else {
			$content = str_replace(
				$current_value,
				$value,
				$content
			);
			if( file_put_contents( Pure\Path::root() . '/config.php', $content ) )
				echo "\nSession string [$current_value] changed to: $value\n\n";
			else echo "\nOperation failed!\n\n";
		}

	}

	function run(){
		echo "\n[COMMAND] app:\n" .
            "\t - app:session ?value\n" .
            "\t [set or get the session string for the current application]\n\n";
	}

	protected function findRules( $text, $begin, $end )
	{
		$rules = array();

		$temp = $text;
		$pieces = explode( $begin, $temp );
		while( count( $pieces ) > 1 ){
			$pieces = explode( $end, $pieces[1] );

			$rule = $begin . $pieces[0] . $end;
			array_push( $rules, $rule );

			if( count( $pieces ) == 1 )
				break;

			$temp = str_replace( $rule, '', $temp );
			$pieces = explode( $begin, $temp );
		}

		return $rules;
	}

}

?>