<?php

namespace Pure;
use Pure\Routing\Router;

class Application {

    private static $instance = null;

    private function __construct(){}
    public function __destruct(){}

    // singleton pattern
    public static function main(){
        if(!isset(self::$instance))
            self::$instance = new Application;
        return self::$instance;
    }

    // application services
    private $services = array();

    // paths where to find routes
    private $route_paths = array();

    private $running = false;


    public function run(){
        // run the application only one time
        if($this->running) return;
        $this->running = true;

        // boot the application and services
        $this->boot();

        // load routes
        $this->loadRoutesFrom(Config::get('app.routes_path'));
        foreach($this->route_paths as $path){
            include_directory($path, '.php');
        }

        // load views
        $this->loadViewsFrom(Config::get('app.views_path'));

        // the application is ready, start all the services
        $this->start();

        // dispatch routing
        $router = Router::main();
        if(isset($router))
        {
            if(!$router->dispatch())
            {
                // error, route not found
                echo "Error";
            }
        }

        // stop all the services
        $this->stop();
    }

    // boot the application and services
    private function boot()
    {
        // load service classes by the config, instantiate here
        $services_classes = config('app.services');
        if(!empty($services_classes))
        {
            foreach($services_classes as $service_class)
            {
                if(class_exists($service_class)){
                    $service = new $service_class;
                    if($service && is_a($service, '\Pure\ApplicationService'))
                    {
                        array_push($this->services, $service);
                    }
                }
            }
        }

        // boot services
        foreach($this->services as $service)
        {
            $service->boot();
        }
    }

    // start all the application services
    private function start()
    {
        // start services
        foreach($this->services as $service)
        {
            $service->start();
        }
    }

    // end all the application services
    private function stop()
    {
        // stop services
        foreach($this->services as $service)
        {
            $service->stop();
        }
    }

    public function loadRoutesFrom($path){
        if(in_array($path, $this->route_paths) == false)
            array_push($this->route_paths, $path);
    }

    public function loadViewsFrom($path, $namespace = null){
        Template\View::namespace($path, $namespace);
    }

    public function registerService($service){
        array_push($this->services, $service);
    }
}

?>
