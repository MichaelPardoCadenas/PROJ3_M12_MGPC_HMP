<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$level = isset($_GET['level']) ? intval($_GET['level']) : 1;
$amount = isset($_GET['amount']) ? intval($_GET['amount']) : 1;

if ($amount < 1 || $amount > 10) {
    $amount = 1;
}

$stmt = $conn->prepare("SELECT * FROM questions WHERE difficulty = ? ORDER BY RAND() LIMIT ?");
$stmt->bind_param("ii", $level, $amount);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = [
        'id' => $row['id'],
        'question_text' => $row['question_text'],
        'answer_a' => $row['answer_a'],
        'answer_b' => $row['answer_b'],
        'answer_c' => $row['answer_c'],
        'answer_d' => $row['answer_d'],
        'correct_answer' => $row['correct_answer'],
        'difficulty' => $row['difficulty']
    ];
}

echo json_encode([
    'status' => 'success',
    'questions' => $questions
]);

$stmt->close();
$conn->close();
?>
