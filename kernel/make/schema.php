<?php

namespace App\Schemas;
use Pure\SchemaHandler;

class RESOURCE_NAME extends SchemaHandler
{
    public static function table(){
        return "TABLE_NAME"; // EDIT
    }

    static function define($schema){
        $schema->add('id', 'INT');
        // EDIT
    }
}

?>
