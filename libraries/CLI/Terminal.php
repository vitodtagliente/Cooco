<?php

namespace Pure\CLI;

class Terminal {

    private static $path = null;

    function __construct(){

    }

    public function run( $arguments = array() ){

        $command = array_shift( $arguments );
        // if funcname contains ':' like this case = 'controller:make'
        // it means that we have to call the controller command object
        // and use the make method
        $action = 'run';
        if ( strpos( $command, ':' ) !== false )
        {
            $pieces = explode( ':', $command );
            $command = $pieces[0];
            $action = $pieces[1];
        }

        // include the command file
        $filename = self::path() . "/$command.php";
        if( file_exists( $filename ) == false ){
            echo "Error, cannot find $command command\n";
            return;
        }
        require_once $filename;

        $instance = new $command();
        if ( is_callable( array( $instance, $action ) ) )
            call_user_func_array( array( $instance, $action ), $arguments );
        else echo "Cannot call $command:$action\n";
    }

    /*
        set or return the default path where controllers will be looked at
    */
    public static function path($path = null){
        if(isset($path))
            self::$path = $path;
        else return self::$path;
    }

    function __destruct(){

    }

}

?>
