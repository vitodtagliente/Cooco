<?php

namespace Pure\CLI;

class Terminal {

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
        $filename = __DIR__ . "/commands/$command.php";
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


    function __destruct(){

    }

}

?>
