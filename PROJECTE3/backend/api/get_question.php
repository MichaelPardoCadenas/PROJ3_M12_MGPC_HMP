<?php
header("Content-Type: application/json");
require_once '../db/connection.php';

$difficulty = isset($_GET['level']) ? intval($_GET['level']) : 1;

if ($difficulty < 1 || $difficulty > 3) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'El nivel debe ser 1, 2 o 3.'
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT id, question_text, answer_a, answer_b, answer_c, answer_d, correct_answer
    FROM questions
    WHERE difficulty = ?
    ORDER BY RAND()
    LIMIT 1
");
$stmt->bind_param("i", $difficulty);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $question = $result->fetch_assoc();

    echo json_encode([
        'status' => 'success',
        'question' => [
            'id' => $question['id'],
            'question_text' => $question['question_text'],
            'answer_a' => $question['answer_a'],
            'answer_b' => $question['answer_b'],
            'answer_c' => $question['answer_c'],
            'answer_d' => $question['answer_d'],
            'correct_answer' => $question['correct_answer'] // aseguramos que se incluya
        ]
    ]);
} else {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'No se encontró pregunta.'
    ]);
}

$stmt->close();
$conn->close();
