<?php
$host = getenv('DB_HOST') ?: 'sql7.freesqldatabase.com';
$db_name = getenv('DB_NAME') ?: 'sql8607642';
$db_user = getenv('DB_USER') ?: 'sql8607642';
$db_password = getenv('DB_PASSWORD') ?: '7pcVKI8EH4';

$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
