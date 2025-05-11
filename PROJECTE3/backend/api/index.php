<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../db/connection.php';

$app = AppFactory::create();

// Establece base path si es necesario
$app->setBasePath('/api');

// Middleware de enrutamiento y body parsing
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Middleware CORS (opcional para desarrollo)
$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
});

// Ruta raíz opcional
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Rich or Bust API");
    return $response;
});

// Ruta: GET /api/get_question.php
$app->get('/get_question.php', function (Request $request, Response $response) use ($conn) {
    require __DIR__ . '/get_question.php';
    return $response;
});

// Ruta: POST /api/submit_scores.php
$app->post('/submit_scores.php', function (Request $request, Response $response) use ($conn) {
    require __DIR__ . '/submit_scores.php';
    return $response;
});

// Ruta: GET /api/get_scores.php
$app->get('/get_scores.php', function (Request $request, Response $response) use ($conn) {
    require __DIR__ . '/get_scores.php';
    return $response;
});

$app->run();
