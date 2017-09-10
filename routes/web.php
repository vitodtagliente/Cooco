<?php

$router = Pure\Application::main()->router();
$router->namespace("App\\Controller\\");

$router->get('/', 'WelcomeController@index');

?>
