<?php

namespace Pure;

class ViewScriptEngine {

	function map( $text ){

		$text = $this->mapExtends( $text );

		$scripts = $this->findScripts( $text, '{{', '}}' );

        if( count( $scripts ) > 0 ){
            foreach ($scripts as $script) {
                $s = str_replace( '{{', '', $script );
                $s = str_replace( '}}', '', $s );
                $s = trim( $s );
                $s = rtrim( $s, ';' );
				/*
                $error = false;
                $argv = array();
                $argf = null;
                $value = null;
                $arguments = null;

                if( strpos( $s, '::' ) !== false){
                    $p = explode( '::', $s );
                    $class = trim( $p[0] );
                    if( class_exists( $class ) ){
                        $method = trim( $p[1] );
                        if( strpos( $method, '(' ) !== false){
                            $p = explode( '(', $method );
                            $method = trim( $p[0] );
                            $arguments = trim( str_replace( ')', null, $p[1] ) );
                        }
                        $argf = array( $class, $method );
                    }
                }
                else {
                    if( strpos( $s, '(' ) !== false){
                        $p = explode( '(', $s );
                        $arguments = trim( str_replace( ')', '', $p[1] ) );
                        if( function_exists( $p[0] ) )
                            $argf = trim( $p[0] );
                    }
                }

                if( isset( $argf ) ){
                    $value = call_user_func_array( $argf, $this->mapArguments($arguments) );
                }
				*/
				$s = "return $s;";
				$value = eval($s);
                $text = str_replace( $script, $value, $text );
            }
        }
        return $text;

	}

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
