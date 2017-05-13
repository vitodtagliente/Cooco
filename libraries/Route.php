<?php

namespace Cooco;

class Route {

    private $callback = null;
    private $params = [];

    public static $controllersPath = null;

    private static $onstringhandler = null;
    private static $ondatahandler = null;

    function __construct( $callback, $params ){
        $this->callback = $callback;
        $this->params = $params;

        if( $this->params == null )
            $this->params = [];
    }

    public function call(){
        if( is_array( $this->callback ) ){
            if( self::$ondatahandler != null){
                $result = call_user_func_array(
                    self::$ondatahandler,
                    [$this->callback, $this->params]
                );
                return ($result==null)?true:$result;
            }
            else return $this->defaultOnData( $this->callback, $this->params );
        }
        else if( is_callable( $this->callback ) ){
            call_user_func_array( $this->callback, $this->params );
            return true;
        }
        else if( is_string( $this->callback ) ){
            if( self::$onstringhandler != null ){
                $result = call_user_func_array(
                    self::$onstringhandler,
                    [$this->callback, $this->params]
                );
                return ($result==null)?true:$result;
            }
            else return $this->defaultOnString( $this->callback, $this->params );
        }
        else return false;
    }

    private function defaultOnData( $data, $params ){
        $filename = $data['filename'];
        $classname = $data['classname'];
        $action = $data['action'];
        if($action == null)
            $action = 'index';

        return $this->callController( $filename, $classname, $action, $params );
    }

    private function defaultOnString( $data, $params ){
        $classname = $data;
        $action = 'index';
        if (($strpos = strpos($data, '@')) !== false){
            $pieces = explode( '@', $data );
            $classname = $pieces[0];
            $action = $pieces[1];
        }
        $filename = self::$controllersPath . '/' . $classname . '.php';

        return $this->callController( $filename, $classname, $action, $params );
    }

    private function callController( $filename, $classname, $action, $params ){
        // include file if exists
        if( isset( $filename ) && file_exists( $filename ) ){
            include_once $filename;
        }
        else return false;

        $_obj = null;
        if( class_exists( $classname ) ){
            $_obj = new $classname();
        }
        else return false;

        if( isset( $action ) && $_obj != null ){

            if ( is_callable( array( $_obj, $action ) ) )
                call_user_func_array( array( $_obj, $action ), $params );
            else return false;

        }
        return true;
    }

    public static function onString( $handler ){
        self::$onstringhandler = $handler;
    }

    public static function onData( $handler ){
        self::$ondatahandler = $handler;
    }

    function __destruct(){

    }

}

?>
