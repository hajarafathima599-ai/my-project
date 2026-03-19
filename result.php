<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';
requireLogin();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare('SELECT score, total_questions FROM quiz_results WHERE id = ? AND user_id = ? LIMIT 1');
$stmt->bind_param('ii', $id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    redirect('dashboard.php');
}

$score = (int) $row['score'];
$total = (int) $row['total_questions'];
$percentage = $total > 0 ? ($score / $total) * 100 : 0;

if ($percentage == 100) {
    $message = 'Excellent Work!';
    $messageClass = 'text-success';
    $iconClass = 'bi bi-trophy-fill text-warning';
} elseif ($percentage >= 60) {
    $message = 'Good Attempt!';
    $messageClass = 'text-primary';
    $iconClass = 'bi bi-hand-thumbs-up-fill text-primary';
} else {
    $message = 'Try Again!';
    $messageClass = 'text-danger';
    $iconClass = 'bi bi-exclamation-circle-fill text-danger';
}

$pageTitle = 'Quiz Results - Quizify';
$basePath = '';
require_once __DIR__ . '/includes/header.php';
?>
<main class="d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="result-card p-5 text-center">
                    <div class="mb-4"><i class="<?= $iconClass; ?>" style="font-size: 4rem;"></i></div>
                    <h2 class="fw-bold mb-3 <?= $messageClass; ?>"><?= $message; ?></h2>
                    <p class="text-muted mb-4">You have completed the quiz.</p>
                    <div class="bg-light rounded p-4 mb-4 border">
                        <div class="row g-0 align-items-center">
                            <div class="col-6 border-end">
                                <h1 class="display-4 fw-bold text-primary mb-0"><?= $score; ?></h1>
                                <p class="text-muted small mb-0 text-uppercase">Correct</p>
                            </div>
                            <div class="col-6">
                                <h1 class="display-4 fw-bold text-secondary mb-0"><?= $total; ?></h1>
                                <p class="text-muted small mb-0 text-uppercase">Total Questions</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-5">
                        <a href="quiz.php" class="btn btn-primary-custom px-4">Restart Quiz <i class="bi bi-arrow-repeat ms-2"></i></a>
                        <a href="dashboard.php" class="btn btn-outline-secondary px-4">Go to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
