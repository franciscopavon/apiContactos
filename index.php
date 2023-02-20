<?php
require 'vendor/autoload.php';
require 'bootstrap.php';
require 'src/Contacto.php';
require 'src/Usuario.php';
require 'src/DatabaseHelper.php';

use \Firebase\JWT\JWT;

use \Firebase\JWT\Key;

include 'bootstrap.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$key = $_ENV['KEY'];

if (isset($uri[2])) {
    $userId = (int) $uri[2];
} else {
    $userId = null;
}

if ($uri[1] !== 'contactos' && $uri[1] !== 'login' && $uri[1] !== 'testLogin' && $uri[1] !== 'testing') {
    header("HTTP/1.1 404 Not Found");
    exit();
} else {
    if ($uri[1] === 'contactos') {
        contactLogic($requestMethod, $userId);
    } else if ($uri[1] === 'login') {
        loginLogic();
    } else if ($uri[1] === 'testLogin') {
        testLoginLogic();
    }
}

function loginLogic(){
    $data = json_decode(file_get_contents("php://input"));
    $usuario = login($data->usuario, $data->password);
    if($usuario != null){
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "data" => array(
                "id" => $usuario->id,
                "usuario" => $usuario->usuario,
                "password" => $usuario->password
            )
        );
        $jwt = JWT::encode($token, "test-key", 'HS256');
        echo json_encode(array("message" => "Login correcto", "jwt" => $jwt));
    }else{
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }
}

function contactLogic($requestMethod, $userId)
{
    headerJSONinit();

    $dataForToken = json_decode(file_get_contents("php://input"));

    if(!checkToken($dataForToken->token)){
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }

    switch ($requestMethod) {
        case 'GET':
            if ($userId != null) {
                $contacto = getContactoById($userId);
                echo json_encode($contacto);
            } else {
                $contactos = getAllContactos();
                echo json_encode($contactos);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $contacto = new Contacto(null, $data->nombre, $data->telefono, $data->email, null, null);
            try {
                addNewContacto($contacto);
            } catch (\Throwable $th) {
                header("HTTP/1.1 500 Internal Server Error");
                exit();
            }
            echo json_encode($contacto);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $contacto = new Contacto($data->id, $data->nombre, $data->telefono, $data->email, null, null);
            try {
                updateContacto($contacto);
            } catch (\Throwable $th) {
                header("HTTP/1.1 500 Internal Server Error");
                exit();
            }
            echo json_encode($contacto);
            break;
        case 'DELETE':
            try {
                deleteContacto($userId);
            } catch (\Throwable $th) {
                header("HTTP/1.1 500 Internal Server Error");
                exit();
            }
            echo json_encode(array("message" => "Contacto eliminado"));
            break;
        default:
            header("HTTP/1.1 404 Not Found");
            exit();
            break;
    }
}

function testLoginLogic(){
    headerJSONinit();
    if(checkToken()){
        echo json_encode(array("message" => "Token correcto"));
    }else{
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }
}

function checkToken(){
    $data = json_decode(file_get_contents("php://input"));
    $token = $data->token;
    try {
        $decoded = JWT::decode($token, new Key("test-key", 'HS256'));
        return true;
    } catch (\Throwable $th) {
        echo json_encode(array("message" => "ERROR: Token incorrecto"));
        return false;
    }
}

function headerJSONinit()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}
