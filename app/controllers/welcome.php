<?php

class WelcomeController extends Cooco\Controller {

    function index(){
        View::make('welcome.php');
    }

}

?>
