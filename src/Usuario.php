<?php

class Usuario{
    public $id;
    public $usuario;
    public $password;

    public function __construct($id, $usuario, $password){
        $this->id = $id;
        $this->usuario = $usuario;
        $this->password = $password;
    }
}