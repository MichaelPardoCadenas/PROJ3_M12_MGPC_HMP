<?php
header("Content-Type: application/json");

// Incluir conexión a la base de datos
require_once '../db/connection.php';

// Recoger los datos enviados por POST
$data = json_decode(file_get_contents("php://input"), true);

$username = trim($data['username'] ?? '');
$password = trim($data['password'] ?? '');

// Validar que los campos no estén vacíos
if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Usuario y contraseña son obligatorios.']);
    exit;
}

// Verificar si el nombre de usuario ya existe
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409); // Conflicto
    echo json_encode(['status' => 'error', 'message' => 'El nombre de usuario ya está registrado.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Hashear la contraseña
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insertar nuevo usuario
$insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$insert->bind_param("ss", $username, $hashed_password);

if ($insert->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Usuario registrado correctamente.']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error al registrar el usuario.']);
}

$insert->close();
$conn->close();
?>
