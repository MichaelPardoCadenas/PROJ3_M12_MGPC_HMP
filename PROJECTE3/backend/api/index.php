<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response as SlimResponse;

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../db/connection.php';

// Crear la app
$app = AppFactory::create();

$app->setBasePath('/projecte3/backend/api');


// Middleware de enrutamiento y body parsing
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Middleware CORS (opcional para desarrollo)
$app->add(function (Request $request, RequestHandlerInterface $handler): SlimResponse {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
});

// Ruta POST /login
$app->post('/login', function (Request $request, Response $response) use ($conn) {
    $data = $request->getParsedBody();
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $response->getBody()->write(json_encode([
                'status' => 'success',
                'user' => ['id' => $id, 'username' => $username]
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    $response->getBody()->write(json_encode([
        'status' => 'error',
        'message' => 'Credenciales inválidas'
    ]));
    return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
});

// Ruta POST /register
$app->post('/register', function (Request $request, Response $response) use ($conn) {
    $data = $request->getParsedBody();
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($username) || empty($password)) {
        $response->getBody()->write(json_encode([
            'status' => 'error',
            'message' => 'Usuario y contraseña son obligatorios'
        ]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $response->getBody()->write(json_encode([
            'status' => 'error',
            'message' => 'El usuario ya existe'
        ]));
        return $response->withStatus(409)->withHeader('Content-Type', 'application/json');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $response->getBody()->write(json_encode([
            'status' => 'success',
            'message' => 'Usuario registrado correctamente',
            'user' => ['id' => $user_id, 'username' => $username]
        ]));
    } else {
        $response->getBody()->write(json_encode([
            'status' => 'error',
            'message' => 'Error al registrar el usuario'
        ]));
    }

    return $response->withHeader('Content-Type', 'application/json');
});

// Ejecutar la app
$app->run();
