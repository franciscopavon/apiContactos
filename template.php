<?php
require 'vendor/autoload.php';

// GET /contactos -> devuelve todos los contactos
// GET /contactos/1 -> devuelve el contacto con id 1
// POST /contactos -> crea un nuevo contacto
// PUT /contactos/1 -> actualiza el contacto con id 1
// DELETE /contactos/1 -> elimina el contacto con id 1

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// all of our endpoints start with /person
// everything else results in a 404 Not Found
if ($uri[1] !== 'contactos' && $uri[1] !== 'login') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the user id is, of course, optional and must be a number:
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

//switch of request method
switch ($requestMethod) {
    case 'GET':
        // Retrieve Contacts
        if($userId){
            // Retrieve Contact
        }else{
            // Retrieve Contacts
        }
        break;
    case 'POST':
        // Create new Contact
        break;
    case 'PUT':
        // Update Contact
        break;
    case 'DELETE':
        // Delete Contact
        break;
    default:
        // Invalid Request Method
        break;
}


function testLogic($requestMethod){
    switch ($requestMethod) {
        case 'GET':
            headerJSONinit();
            $testContacto1 = new Contacto(1, 'Francisco', '123456789', 'mail@mail.com', '2020-01-01', '2020-01-01');
            $testContacto2 = new Contacto(2, 'Pepe', '123456789', 'mail@mail.com', '', '2020-01-01');
            echo json_encode(array($testContacto1, $testContacto2));
            break;
        case 'POST':
            headerJSONinit();
            $data = json_decode(file_get_contents("php://input"));
            $testContacto = new Contacto(1, $data->nombre, $data->telefono, $data->email, '2020-01-01', '2020-01-01');
            echo json_encode($testContacto);
            break;
        case 'PUT':
            // Update Contact
            break;
        case 'DELETE':
            // Delete Contact
            break;
        default:
            // Invalid Request Method
            break;
    }
}
?>
<ul>
    <li><b>$requestMethod: </b>: <?= $requestMethod ?></li>
    <li><b>$userId: </b>: <?= $userId ?></li>
</ul>