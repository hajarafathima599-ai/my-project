<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
    header("Location: $path");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('auth/login.php');
    }
}

function currentUserName() {
    return $_SESSION['username'] ?? 'Guest';
}

function activeClass($current, $page) {
    return $current === $page ? 'active' : '';
}
?>
