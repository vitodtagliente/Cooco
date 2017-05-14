<?php

use Pure\CLI\Command;

class controller extends Command {

    function make( $name ){
    	$filename = Pure\Route::path() . "/$name.php";

        $result = file_put_contents( $filename, 
        	"<?php\n\n" . 
        	"use Pure\Controller;\n" .
        	"use Pure\View;\n\n" .
        	"class $name extends Controller {\n\n" . 
        	"\tfunction index(){\n\n" . 
        	"\t}\n\n" .
        	"}\n\n" . 
        	"?>"
        );
        if( !$result )
            echo "Error: operation failed!";
        else echo "Operation done!";

    }

    function run(){
        echo "\n[COMMAND] controller:\n" .
            "\t - controller:make name\n" .
            "\t [create a controller with specified name]\n\n";
    }

}

?>
