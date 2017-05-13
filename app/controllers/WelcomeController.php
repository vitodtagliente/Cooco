<?php

use Cooco\Controller;
use Cooco\View;

class WelcomeController extends Controller {

    function index(){
        View::make('welcome.php');
    }

}

?>
