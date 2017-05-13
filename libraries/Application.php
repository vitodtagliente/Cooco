<?php

namespace Cooco;

class Application {

    private $_router;

    private static $instance;

    public static $config = [
        'path' => [
            'controllers' => 'app/controllers'
        ]
    ];

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
            echo "Error loading route!";
        }
    }

    function __destruct(){

    }

}

?>
