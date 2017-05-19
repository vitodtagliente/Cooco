<?php

$router = Pure\Application::main()->router();

$router->get('/', 'WelcomeController@index');

?>
