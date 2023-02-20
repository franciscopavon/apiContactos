<?php

class Contacto{

    public $id;
    public $nombre;
    public $telefono;
    public $email;
    public $created_at;
    public $updated_at;

    public function __construct($id, $nombre, $telefono, $email, $created_at, $updated_at){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

}