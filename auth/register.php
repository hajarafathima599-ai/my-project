<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

if (isLoggedIn()) {
    redirect('../dashboard.php');
}

$errors = [];
$success = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($username === '') $errors[] = 'Username is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirmPassword) $errors[] = 'Passwords do not match.';

    $check = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) $errors[] = 'Email already registered.';
    $check->close();

    if (!$errors) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $username, $email, $hashedPassword);
        if ($stmt->execute()) {
            $success = 'Registration successful. You can login now.';
            $username = '';
            $email = '';
        } else {
            $errors[] = 'Registration failed. Please try again.';
        }
        $stmt->close();
    }
}

$pageTitle = 'Register - Quizify';
$activePage = '';
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
                            <img src="../images/login_illustration.png" alt="Register" class="auth-illustration img-fluid">
                        </div>
                        <div class="col-md-7 p-4 p-md-5">
                            <h2 class="fw-bold mb-2">Create Account</h2>
                            <p class="text-muted mb-4">Register to access the quiz system.</p>

                            <?php if ($errors): ?>
                                <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $error): ?><li><?= $error; ?></li><?php endforeach; ?></ul></div>
                            <?php endif; ?>
                            <?php if ($success): ?>
                                <div class="alert alert-success"><?= $success; ?></div>
                            <?php endif; ?>

                            <form method="POST" id="registerForm" novalidate>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?= $username; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $email; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-medium">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary-custom">Register <i class="bi bi-person-plus ms-2"></i></button>
                                </div>
                                <p class="mb-0 text-muted">Already have an account? <a href="login.php">Login here</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
