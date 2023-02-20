<?php
require_once 'Database.php';
require_once 'Contacto.php';
require_once 'Usuario.php';

function getAllContactos(){
    $db = new Database();
        $db->connect();
        $result = $db->get('contactos', '*');
        $contactos = array();
        foreach($result as $row){
            $contactos[] = new Contacto($row['id'], $row['nombre'], $row['telefono'], $row['email'], $row['created_at'], $row['updated_at']);
        }
        $db->disconnect();
        return $contactos;
}

function getContactoById($id){
    $db = new Database();
    $db->connect();
    $result = $db->getWhere('contactos', '*', "id = $id");
    $db->disconnect();
    if(count($result) > 0){
        return new Contacto($result[0]['id'], $result[0]['nombre'], $result[0]['telefono'], $result[0]['email'], $result[0]['created_at'], $result[0]['updated_at']);
    }else{
        return null;
    }
}

function addNewContacto($contacto){
    $db = new Database();
    $db->connect();
    $result = $db->insert('contactos', 'nombre, telefono, email', "'$contacto->nombre', '$contacto->telefono', '$contacto->email'");
    $db->disconnect();
    return $result;
}

function updateContacto($contacto){
    $db = new Database();
    $db->connect();
    $result = $db->update('contactos', "nombre = '$contacto->nombre', telefono = '$contacto->telefono', email = '$contacto->email'", "id = $contacto->id");
    $db->disconnect();
    return $result;
}

function deleteContacto($id){
    $db = new Database();
    $db->connect();
    $result = $db->delete('contactos', "id = $id");
    $db->disconnect();
    return $result;
}

function login($username, $password){
    $db = new Database();
    $db->connect();
    $result = $db->getWhere('usuarios', '*', "usuario = '$username' AND password = '$password'");
    $db->disconnect();
    if(count($result) > 0){
        return new Usuario($result[0]['id'], $result[0]['usuario'], $result[0]['password']);
    }else{
        return null;
    }
}