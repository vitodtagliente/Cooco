<?php

namespace Pure;
use Pure\ORM\Schema;
use Pure\ORM\SchemaBuilder;

abstract class SchemaHandler {

    // if $override_schema is equal to true
    // if the table exists it will be deleted
    public static function create($override_schema = false)
    {
        if(Schema::exists(self::table()))
        {
            if($override_schema)
                Schema::drop(self::table());
            else return;
        }

        $schema = new Schema(self::table());
        self::define($schema);
        return Schema::create( $schema->query() );
    }

    // return the table name
    public static abstract function table();

    // define the schema fields
    protected static abstract function define($schema);

}

?>
