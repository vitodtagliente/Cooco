<?php

$router = Pure\Application::main()->router();

$router->get('/', function(){
    echo "Hello Pure!";
});

?>
