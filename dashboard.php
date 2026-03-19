<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';
requireLogin();

$stmt = $conn->prepare('SELECT score, total_questions, created_at FROM quiz_results WHERE user_id = ? ORDER BY id DESC');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$results = $stmt->get_result();

$pageTitle = 'Dashboard - Quizify';
$activePage = 'dashboard';
$basePath = '';
require_once __DIR__ . '/includes/header.php';
?>
<main class="py-5">
    <div class="container">
        <div class="quiz-card p-4 p-md-5 mb-4">
            <h2 class="fw-bold mb-2">Welcome, <?= sanitize(currentUserName()); ?>!</h2>
            <p class="text-muted mb-4">This is your dashboard. Start a new quiz or review your saved score history.</p>
            <a href="quiz.php" class="btn btn-primary-custom me-2">Start Quiz</a>
            <a href="contact.php" class="btn btn-outline-secondary">Contact Us</a>
        </div>

        <div class="result-card p-4 p-md-5">
            <h3 class="fw-bold mb-4">Quiz Result History</h3>
            <?php if ($results->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Score</th>
                                <th>Total Questions</th>
                                <th>Percentage</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; while ($row = $results->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= $row['score']; ?></td>
                                    <td><?= $row['total_questions']; ?></td>
                                    <td><?= round(($row['score'] / $row['total_questions']) * 100); ?>%</td>
                                    <td><?= $row['created_at']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">No quiz results yet. Start your first quiz.</div>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
