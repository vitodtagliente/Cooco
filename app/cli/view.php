<?php

use Pure\CLI\Command;

class view extends Command {

	function make( $name ){
    	$filename = Pure\View::path() . "/$name.php";

        $result = file_put_contents( $filename, 
        	"<html>\n" . 
        	"\t<head>\n" .
        	"\t\t<title>$name</title>\n" .
        	"\t</head>\n" . 
        	"\t<body>\n\n" .
        	"\t</body>\n" . 
        	"</html>"
        );
        if( !$result )
            echo "Error: operation failed!\n\n";
        else echo "Operation done!\n\n";

    }

    function run(){
        echo "\n[COMMAND] view:\n" .
            "\t - view:make name\n" .
            "\t [create a view with specified name]\n\n";
    }

}

?>