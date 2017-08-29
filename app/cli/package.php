<?php

use Pure\CLI\Command;

class package extends Command {

	function install($name){
		echo "\nInstalling package: $name...\n\n";
	}

	function remove($name){
		echo "\nRemoving package: $name...\n\n";
	}

	function run(){
		echo "\n[COMMAND] package:\n" .
            "\t - package:install name\n" .
            "\t [install the package with specified name]\n" .
 			"\t - package:remove name\n" .
            "\t [remove the package with specified name]\n\n";
	}

}

?>