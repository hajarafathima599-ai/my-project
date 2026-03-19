<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('quiz.php');
}

$score = isset($_POST['score']) ? (int) $_POST['score'] : 0;
$total = isset($_POST['total']) ? (int) $_POST['total'] : 0;

if ($total <= 0) {
    redirect('quiz.php');
}

$stmt = $conn->prepare('INSERT INTO quiz_results (user_id, score, total_questions) VALUES (?, ?, ?)');
$stmt->bind_param('iii', $_SESSION['user_id'], $score, $total);
$stmt->execute();
$resultId = $stmt->insert_id;
$stmt->close();

redirect('result.php?id=' . $resultId);
?>
