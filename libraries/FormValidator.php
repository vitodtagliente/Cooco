<?php

/*
    HOW TO:

    $form = new FormValidator($method)
        - where $method can be 'POST' (by default) or 'GET'

    register all the input:

        $form->input('id');
        $form->input('name');
        ..........
        $form->input('email');

    check the validation state:

        $error = [];
        $result = $form->validate( $error );

        - $result will be true or false
        - $error will contains all the input that are not valid
            like this: $error = ['id', 'name', ... ]

    get input value by:

        $id = $form->value('id');
        $name = $form->value('name');
        .......
        $email = $form->value('email');

*/

namespace Pure;

class FormValidator {

    private $method;

    function __construct($method = 'POST'){
        $this->method = $method;
    }

    private $fields = [];

    function input($name){
        if( !in_array( $name, $this->fields ) )
            array_push( $this->fields, $name );
    }

    function value($name){
        if( in_array($name, $this->fields) ){
            if( $this->method == 'GET' )
                return Request::get($name);
            else return Request::post($name);
        }
        else return null;
    }

    function validate(&$result){
        $result = [];
        foreach ($this->fields as $name) {
            $r = empty( $this->value($name) );

            if($r == true)
                array_push( $result, $name );
        }
        return count($result) == 0;
    }

}

?>
