<?php

use Pure\Controller;
use Pure\View\View;

class WelcomeController extends Controller {

    function index(){

        View::make('welcome.php');

    }

}

?>
