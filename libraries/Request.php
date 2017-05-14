<?php

namespace Pure;

class Request {
    private function __construct(){}

    public static function post( $key ){
        if( !empty( $_POST ) && isset( $_POST[ $key ] ) )
                return $_POST[ $key ];
        else return null;
    }

    public static function get( $key ){
        if( !empty( $_GET ) && isset( $_GET[ $key ] ) )
                return $_GET[ $key ];
        else return null;
    }

    public static function input( $key ){
      $method = $_SERVER['REQUEST_METHOD'];
      if( $method == 'GET')
        return self::get( $key );
      else if( $method == 'POST' )
        return self::post( $key );
      else return null;
    }

    private function __destruct(){}
}

?>