<?php
header("Content-Type: application/json");

require_once '../db/connection.php';

// Obtener datos enviados por POST (JSON)
$data = json_decode(file_get_contents("php://input"), true);

$user_id = intval($data['user_id'] ?? 0);
$score = intval($data['score'] ?? -1);

// Validaciones básicas
if ($user_id <= 0 || $score < 0) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Datos inválidos. user_id y score son obligatorios.'
    ]);
    exit;
}

// Verificar que el usuario existe
$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Usuario no encontrado.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Insertar puntuación
$insert = $conn->prepare("INSERT INTO scores (user_id, score) VALUES (?, ?)");
$insert->bind_param("ii", $user_id, $score);

if ($insert->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Puntuación guardada correctamente.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al guardar la puntuación.'
    ]);
}

$insert->close();
$conn->close();
?>
