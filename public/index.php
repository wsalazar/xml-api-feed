<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('App\\', __DIR__);

$app = new \Slim\App;

require_once('../app/api/get_xml.php');


$app->get('/', function (Request $request, Response $response, $args){
    $response->getBody()->write("Hello World");
    return $response;
});

//Run app
$app->run();
