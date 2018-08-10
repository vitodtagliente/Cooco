<?php

namespace Pure;

class Shell
{
    private function __construct(){}
    private function __destruct(){}

    public static function execute($command, $arguments)
    {
        if(!isset($command))
        {
            return;
        }

        $class_name = 'Pure\\Commands\\' . $command;
        if(class_exists($class_name))
        {
            $cmd_object = new $class_name;
            
            if(!$cmd_object || !is_a($cmd_object, '\Pure\Command'))
                return;

            if(in_array('--help', $arguments) || in_array('-h', $arguments))
                $cmd_object->help();
            else $cmd_object->execute($arguments);
        }
    }
}

?>
