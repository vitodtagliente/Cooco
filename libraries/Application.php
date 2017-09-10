<?php

namespace Pure;
use Pure\Routing\Router;

class Application {

    private static $instance;

    private $errorHandler = null;

    function __construct(){
        if( self::$instance == null )
            self::$instance = $this;
    }

    public static function main(){
        return self::$instance;
    }

    public function router(){
        return Router::main();
    }

    public function run(){
        if( !$this->router()->dispatch() ){
            if( $this->errorHandler == null )
                echo "404. Route not found!";
            else call_user_func( $this->errorHandler );
        }
    }

    private function include_directory($directory, $extension = '.php') {
        if(is_dir($directory)) {
            $scan = scandir($directory);
            unset($scan[0], $scan[1]); //unset . and ..
            foreach($scan as $file) {
                if(is_dir($directory."/".$file)) {
                    $this->include_directory($directory."/".$file, $extension);
                } else {
                    if(strpos($file, $extension) !== false) {
                        include_once($directory."/".$file);
                    }
                }
            }
        }
    }

    public function loadRoutes($directory = null){
        if( empty($directory) )
            $directory = Path::routes();

        $this->include_directory($directory);
    }

    public function onError($callback){
        $this->errorHandler = $callback;
    }

    function __destruct(){

    }

}

?>
