<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});



//OJO ESTE COMENTARIO NO VA - al escribir la siguiente línea, probar
//en el navegador

///crear las rutas de clientes
require "../src/routes/clientes.php";


$app->run();


