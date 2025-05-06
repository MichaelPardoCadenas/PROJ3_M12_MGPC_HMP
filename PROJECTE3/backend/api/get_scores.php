<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$stmt = $conn->prepare("
  SELECT u.username, s.score
  FROM scores s
  JOIN users u ON s.user_id = u.id
  ORDER BY s.score DESC
  LIMIT 10
");

if (!$stmt->execute()) {
  echo json_encode([
    'status' => 'error',
    'message' => 'No se pudo obtener el ranking'
  ]);
  exit;
}

$result = $stmt->get_result();
$scores = [];

while ($row = $result->fetch_assoc()) {
  $scores[] = [
    'username' => $row['username'],
    'score' => $row['score']
  ];
}

echo json_encode([
  'status' => 'success',
  'scores' => $scores
]);

$stmt->close();
$conn->close();
?>
