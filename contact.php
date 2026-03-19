<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/db.php';

$name = '';
$email = '';
$message = '';
$success = '';
$error = '';

if (isLoggedIn()) {
    $name = $_SESSION['username'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter a valid email.';
    } else {
        $stmt = $conn->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $email, $message);
        if ($stmt->execute()) {
            $success = 'Your message was sent successfully.';
            $name = isLoggedIn() ? $_SESSION['username'] : '';
            $email = '';
            $message = '';
        } else {
            $error = 'Failed to save the message.';
        }
        $stmt->close();
    }
}

$pageTitle = 'Contact - Quizify';
$activePage = 'contact';
$basePath = '';
require_once __DIR__ . '/includes/header.php';
?>
<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="auth-card p-4 p-md-5">
                    <h2 class="fw-bold mb-2">Contact Us</h2>
                    <p class="text-muted mb-4">Send your questions or feedback. Messages are stored in the database.</p>
                    <?php if ($error): ?><div class="alert alert-danger"><?= $error; ?></div><?php endif; ?>
                    <?php if ($success): ?><div class="alert alert-success"><?= $success; ?></div><?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Name</label>
                            <input type="text" class="form-control" name="name" value="<?= $name; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $email; ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Message</label>
                            <textarea class="form-control" name="message" rows="5" required><?= $message; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary-custom">Send Message <i class="bi bi-send ms-2"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
