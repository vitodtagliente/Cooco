<?php

namespace Pure;

class Application {

    private $_router;

    private static $instance;

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
            View::make( 'system/error.php', ['text' => 'Cannot find the route!']);
        }
    }

    function __destruct(){

    }

}

?>
