<?php
$host = 'sql7.freesqldatabase.com	';     // o el host exacto que te dieron
$user = 'sql7777905';                  // tu usuario
$pass = '7pcVKI8EH4';               // tu contraseña
$db   = 'sql7777905';                  // normalmente es igual que el usuario

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error de conexión: ' . $conn->connect_error
    ]);
    exit;
}

$conn->set_charset("utf8");
