<?php

class command extends Pure\CLI\Command {

    function make( $name ){
    	$filename = Pure\CLI\Terminal::path() . "/$name.php";

        $result = file_put_contents( $filename, 
        	"<?php\n\n" . 
        	"use Pure\CLI\Command;\n\n" .
        	"class $name extends Command {\n\n" . 
        	"\tfunction run(){\n\n" . 
        	"\t}\n\n" .
        	"}\n\n" . 
        	"?>"
        );
        if( !$result )
            echo "Error: operation failed!\n\n";
        else echo "Operation done!\n\n";

    }

    function run(){
        echo "\n[COMMAND] command:\n" .
            "\t - command:make name\n" .
            "\t [create a command with specified name]\n\n";
    }

}

?>
