<?php

namespace Pure;

class ViewScriptEngine {

	// Map php functions and variables

	function map( $__pure_view_content, $__pure_view_params = array() ){

		$__pure_view_content = $this->mapExtends( $__pure_view_content, $__pure_view_params );

		$__pure_view_scripts = $this->findScripts( $__pure_view_content, '{{', '}}' );

        foreach ($__pure_view_scripts as $__pure_view_script) {
        	// trim each script
            $__pure_view_s = str_replace( '{{', '', $__pure_view_script );
            $__pure_view_s = str_replace( '}}', '', $__pure_view_s );
            $__pure_view_s = trim( $__pure_view_s );

            $__pure_words_count = str_word_count( $__pure_view_s );

            if( $__pure_words_count == 1 && strpos($__pure_view_s, '$') === 0 ){            	
            	// it's a single word, one variable
            	// try to replace it using eval 
            	$__pure_view_s = rtrim( $__pure_view_s, ';' );

            	$__pure_view_value = eval("return $__pure_view_s;");

            	// if eval fails
				// try to find a match with view's params
				if ($__pure_view_value == null){

					$__pure_view_s = ltrim( $__pure_view_s, '$' );

					foreach ($__pure_view_params as $__pure_key => $__pure_value) {
						if($__pure_key == $__pure_view_s)
							$__pure_view_value = $__pure_value;
					}
				}
            }
            else {
            	// eval the script
            	// TODO: exception handler
				$__pure_view_value = eval($__pure_view_s);
            }			

            $__pure_view_content = str_replace( $__pure_view_script, $__pure_view_value, $__pure_view_content );
        }
        return $__pure_view_content;

	}

	/*
		Returns an array of all scripts found.
		Example: findScripts( text, '{{', '}}' );
		[
			'{{ script1; }}',
			'{{ script2; }}',
				.......
			'{{ scriptn; }}'
		]
	*/
	private function findScripts( $text, $begin, $end )
	{
		$scripts = array();

		$temp = $text;
		$pieces = explode( $begin, $temp );
		while( count( $pieces ) > 1 ){
			$pieces = explode( $end, $pieces[1] );
			if( count( $pieces ) == 1 )
				break;

			$script = $begin . $pieces[0] . $end;
			array_push( $scripts, $script );

			$temp = str_replace( $script, '', $temp );
			$pieces = explode( $begin, $temp );
		}

		return $scripts;
	}

	// explode a string and returns all the arguments found
	// Example: 'foo', 1, 2, 'test'
	// output = ['foo', 1, 2, 'test']
	private function mapArguments( $text )
	{
		$argv = [];
		if(!empty($text))
		{
			$args = explode( ',', $text );
			foreach ($args as $a) {
				// trim the argument
				$a = trim( $a );
				$a = trim( $a, "'" );
				$a = trim( $a, '"' );
				$a = trim( $a );
				// parse null
				if( strtolower($a) == "null" )
					$a = null;
				array_push( $argv, $a );
			}
		}

		return $argv;
	}

	/*
		implements the view's extension capability
		Example:
			@extends('filename')
			- filename represents a view to extend

			[NOTE] extends must be the first statement

		In parent View can be defined sections to be override
		with expression: @section('name')

		To override a section, do like follow:
		@begin('name')
		...code...
		@end
	*/
	private function mapExtends( $text, $params = array() ){

		$scripts = $this->findScripts( $text, '@', ')' );

		$contains_extends = false;
		$base = $text;

		var_dump($scripts);

        foreach ($scripts as $script)
		{
			// trim scripts
			$s = str_replace( '@', '', $script );
			$s = str_replace( ')', '', $s );
            $s = trim( $s );
            $s = rtrim( $s, ';' );

			$pieces = explode('(', $s);
			$func = $pieces[0];
			$arguments = $pieces[1];

			$argv = $this->mapArguments($arguments);

			if($func == 'extends')
			{
				// Use a view as template
				$contains_extends = true;
				ob_start();
				View::make($argv[0], $params);
				$base = ob_get_contents();
				ob_end_clean();
				continue;
			}
			/*
				if contains a begin('name'), override the section
				remember to find the @end tag
			*/
			else if($func == 'begin')
			{
				if($contains_extends && count($argv) > 0 && !empty($argv[0]))
				{
					$pieces = explode($script, $text);
					$pieces = explode('@end', $pieces[1]);
					if(count($pieces) > 0)
					{
						$key = $argv[0];
						$value = $pieces[0];

						$base = str_replace("@section('$key')", $value, $base);
						$base = str_replace("@section($key)", $value, $base);
						$base = str_replace("@section(\"$key\")", $value, $base);
					}
					continue;
				}
			}
			else
			{
				if($func != 'end' && $func != 'section')
					$base = str_replace( $script, '', $base );
			}
		}

		return $base;
	}
}

?>
