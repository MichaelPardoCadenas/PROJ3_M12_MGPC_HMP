<?php
$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'rich_or_bust';

$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error
    ]));
}

$conn->set_charset("utf8");

?>
