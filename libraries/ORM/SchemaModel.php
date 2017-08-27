<?php

namespace Pure\ORM;
use Pure\Database;

abstract class SchemaModel
{
    protected $table = null;

    protected $fields = [];
    private $vars = [];

    private $where = null;

    public function __construct($where = null)
    {
        foreach( $this->fields as $field)
            $this->vars[$field] = null;

        if( !isset( $this->vars['id'] ) )
        {
            $this->vars['id'] = null;
        }

        $this->where = $where;
    }

    public function table()
    {
        return $this->table;
    }

    public function __get( $index ){
		return $this->vars[$index];
	}

	public function __set( $index, $value ){
		$this->vars[$index] = $value;
	}

    public function toArray(){
        return $this->vars;
    }

    public function save()
    {
        if( isset($this->vars['id']) )
        {
            // update
            $result = false;
            if(isset($this->where))
                $result = Database::main()->update( $this->table, $this->where, $this->toArray());

            return $result;
        }
        else
        {
            // insert
            $result = Database::main()->insert( $this->table, $this->vars );
            return $result;
        }
    }

    public function erase()
    {
        if( !isset($this->where) )
            return false;

        $id = $this->vars['id'];
        return Database::main()->delete($this->table, "id = '$id'");
    }

    public function schema(){
        $v = [];
        foreach($this->$vars as $key => $value)
            array_push( $v, $key );
        return $v;
    }

    // static methods

    public static function find($where = null)
    {
        $classname = get_called_class();
        $model = new $classname($where);

        $result = Database::main()->select( $model->table(), null, $where );
        if(!$result)
            return null;

        foreach( $result as $key => $value )
            $model->$key = $value;
        return $model;
    }

    public static function findAll($where = null)
    {
        $classname = get_called_class();
        $temp = new $classname();
        $models = [];

        $result = Database::main()->selectAll( $temp->table(), null, $where );
        foreach ($result as $r)
        {
            $condition = $where;
            if(isset($condition))
            {
                if (strpos($condition,'id') !== true)
                {
                    // dont contains id
                    $condition .= " && id = '$r[id]'";
                }
            }
            else
            {
                $condition = "id = '$r[id]'";
            }
            $model = new $classname($condition);
            foreach( $r as $key => $value )
                $model->$key = $value;
            array_push( $models, $model );
        }
        return $models;
    }

    public static function count(){
		return count( self::findAll() );
	}
}

?>
