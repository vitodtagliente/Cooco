<?php

namespace App\Schemas;
use Pure\SchemaHandler;

class UserSchema extends SchemaHandler
{
    public function table(){
        return "users";
    }

    protected function define($schema){
        $schema->add('id', 'INT');
        $schema->add('email', 'VARCHAR(30)', 'NOT NULL');
        $schema->add('password', 'VARCHAR(30)', 'NOT NULL');
        $schema->unique('email'); // email must be unique
        $schema->increments('id'); // auto_increment
        $schema->primary('id'); // set the primary key
        $schema->add('active', 'BOOLEAN');
        $schema->add('role', 'INTEGER');
    }
}

?>
