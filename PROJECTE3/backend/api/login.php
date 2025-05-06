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

// Buscar al usuario por nombre
$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verificar la contraseña
    if (password_verify($password, $user['password'])) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Login correcto.',
            'user_id' => $user['id']
        ]);
    } else {
        http_response_code(401); // No autorizado
        echo json_encode(['status' => 'error', 'message' => 'Contraseña incorrecta.']);
    }
} else {
    http_response_code(404); // Usuario no encontrado
    echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado.']);
}

$stmt->close();
$conn->close();
?>
