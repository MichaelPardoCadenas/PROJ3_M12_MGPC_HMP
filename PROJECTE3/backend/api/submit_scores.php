<?php
require_once __DIR__ . '/../db/connection.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$score = $data['score'] ?? 0;

if (empty($username) || !is_numeric($score)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO scores (username, score) VALUES (?, ?)");
$stmt->bind_param("si", $username, $score);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'No se pudo guardar la puntuación']);
}
