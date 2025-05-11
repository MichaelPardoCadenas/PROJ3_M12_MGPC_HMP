<?php
require_once __DIR__ . '/../db/connection.php';

header('Content-Type: application/json');

$level = $_GET['level'] ?? 1;
$amount = $_GET['amount'] ?? 5;

$stmt = $conn->prepare("SELECT id, question, correct_answer, wrong_answer1, wrong_answer2 FROM questions WHERE level = ? ORDER BY RAND() LIMIT ?");
$stmt->bind_param("ii", $level, $amount);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];

while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

echo json_encode($questions);
