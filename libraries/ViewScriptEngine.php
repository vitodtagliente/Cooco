<?php

namespace Pure;

class ViewScriptEngine {

	function map( $__pure_view_content, $__pure_view_params = array() ){

		$__pure_view_content = $this->mapExtends( $__pure_view_content );

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
		Returns an array of all scripts found:
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

	private function mapArguments( $text )
	{
		$argv = [];
		if(!empty($text))
		{
			$args = explode( ',', $text );
			foreach ($args as $a) {
				$a = trim( $a );
				$a = trim( $a, "'" );
				$a = trim( $a, '"' );
				$a = trim( $a );
				if( $a == "null" || $a == "NULL" )
					$a = null;
				array_push( $argv, $a );
			}
		}

		return $argv;
	}

	private function mapExtends( $text ){

		$scripts = $this->findScripts( $text, '@', ')' );

		$contains_extends = false;
		$base = $text;

		if( count( $scripts ) > 0 )
		{
            foreach ($scripts as $script)
			{
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
					if(count($argv) > 0 && !empty($argv[0]))
					{
						$contains_extends = true;
						//$base =  file_get_contents(View::path() . '/' . $argv[0]);
						ob_start();
						View::make($argv[0]);
						$base = ob_get_contents();
						ob_end_clean();
						continue;
					}
				}
				else if($func == 'begin')
				{
					if($contains_extends && count($argv) > 0 && !empty($argv[0]))
					{
						$pieces = explode($script, $text);
						if(count($pieces) > 0 ){
							$pieces = explode('@end', $pieces[1]);
							if(count($pieces) > 0)
							{
								//$sections[$argv[0]] = $pieces[0];
								$key = $argv[0];
								$value = $pieces[0];

								$base = str_replace("@section('$key')", $value, $base);
								$base = str_replace("@section($key)", $value, $base);
								$base = str_replace("@section(\"$key\")", $value, $base);
							}
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
		}

		return $base;
	}
}

?>
