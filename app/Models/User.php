<?php

namespace App\Models;
use Pure\Model;

class User extends Model
{
    public function __construct(){
        $this->field('id');
        $this->field('email');
        $this->field('password');
        $this->field('role');
        $this->field('active');
        $this->field('remember_me');
        $this->field('created_at');
        $this->field('updated_at');
        $this->id('id'); // specify the id field
    }
}

?>
