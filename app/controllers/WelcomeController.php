<?php

namespace App\Controller;
use Pure\Controller;
use Pure\Template\View;

class WelcomeController extends Controller {

    function index(){

        View::make('welcome.php');

    }

}

?>
