<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

if (isLoggedIn()) {
    redirect('../dashboard.php');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Email and password are required.';
    } else {
        $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                redirect('../dashboard.php');
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'No account found with this email.';
        }
        $stmt->close();
    }
}

$pageTitle = 'Login - Quizify';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>
<main class="d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="auth-card p-0">
                    <div class="row g-0">
                        <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center bg-light p-4">
                            <img src="../images/login_illustration.png" alt="Student login" class="auth-illustration img-fluid">
                        </div>
                        <div class="col-md-7 p-4 p-md-5">
                            <h2 class="fw-bold mb-2">Welcome Back</h2>
                            <p class="text-muted mb-4">Login to start your quiz.</p>
                            <?php if ($error): ?><div class="alert alert-danger"><?= $error; ?></div><?php endif; ?>
                            <form method="POST" id="loginForm" novalidate>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $email; ?>" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-medium">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary-custom">Login to Start Quiz <i class="bi bi-box-arrow-in-right ms-2"></i></button>
                                </div>
                                <p class="mb-0 text-muted">Don't have an account? <a href="register.php">Register here</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
