<?php

namespace Pure\Commands;
use Pure\Command;

class app extends Command
{
    public function execute($arguments){
        $in_command = array_shift($arguments);

        if(!isset($in_command))
            return;

        if (strpos($in_command, 'make:') === 0) {
            $type_resource = str_replace('make:', '', $in_command);

            if(!empty($type_resource))
            {
                $resource_name = array_shift($arguments);
                if(empty($resource_name))
                    return;

                $folder = __DIR__ . '/../../app/' . ucfirst($type_resource) . 's';
                $filename = $folder . '/' . $resource_name . '.php';

                $resource_filename = __DIR__ . '/../make/' . $type_resource . '.php';

                if(file_exists($folder) && !file_exists($filename) && file_exists($resource_filename))
                {
                    $file_content = file_get_contents($resource_filename);
                    $file_content = str_replace('RESOURCE_NAME', $resource_name, $file_content);

                    $file = fopen($filename, "w") or die("Unable to open file!");
                    fwrite($file, $file_content);
                    fclose($file);

                    echo "Resource $resource_name" . ucfirst($type_resource) . ' created!';
                }
                else echo "Unable to create the resource";
            }
        }
        else echo "Command not found!";
    }

    public function help(){
        echo "available options:\n";
        echo "- make:command resource_name\n";
        echo "- make:controller resource_name\n";
        echo "- make:middleware resource_name\n";
        echo "- make:model resource_name\n";
        echo "- make:schema resource_name\n";
        echo "- make:service resource_name\n\n";
    }
}

?>
