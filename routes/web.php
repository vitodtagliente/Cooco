<?php

$router->get('/', 'WelcomeController@index');

$router->get('/prova1', 'prova/Prova@index');
$router->get('/prova', '//app/Prova@index');

?>
