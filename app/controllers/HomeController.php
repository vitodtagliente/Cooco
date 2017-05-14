<?php

use Pure\Controller;
use Pure\View;

class HomeController extends Controller {

	function index(){
		View::make('home.php', ['text' => 'prova']);
	}

}

?>