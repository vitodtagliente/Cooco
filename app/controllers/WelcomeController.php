<?php

use Pure\Controller;
use Pure\View;

class WelcomeController extends Controller {

    function index(){
        View::make('welcome.php');
    }

}

?>
