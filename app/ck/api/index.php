<?php
require_once(ROOT_PATH . "/ck/db/handler.php"); 


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require __DIR__ . '/slim/vendor/autoload.php';

//$app = new \Slim\App;
/*
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});
*/

require_once ("./src/routes/tiquetes.php");

//$app->run();

?>