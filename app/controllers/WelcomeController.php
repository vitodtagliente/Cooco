<?php

namespace App\Controllers;
use Pure\Controller;
use Pure\Template\View;

class WelcomeController extends Controller {

    function index(){
        view('welcome.php');
    }

}

?>
