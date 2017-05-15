<?php

namespace Pure;

class Application {

    private $_router;

    private static $instance;
    
    private $errorHandler = null;

    function __construct(){
        if( self::$instance == null )
            self::$instance = $this;
    }

    public static function singleton(){
        return self::$instance;
    }

    public function router(){
        if( $this->_router == null )
            $this->_router = new Router();
        return $this->_router;
    }

    public function run(){
        if( !$this->router()->dispatch() ){
            if( $this->errorHandler == null )
                echo "404. Route not found!";
            else call_user_func( $this->errorHandler );
        }
    }

    public function onError($callback){
        $this->errorHandler = $callback;
    } 

    function __destruct(){

    }

}

?>
