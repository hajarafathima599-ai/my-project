<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Quizify'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= isset($basePath) ? $basePath : '' ?>css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= isset($basePath) ? $basePath : '' ?>index.php">
            <i class="bi bi-mortarboard-fill me-2"></i>Quizify
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link <?= activeClass($activePage ?? '', 'home'); ?>" href="<?= isset($basePath) ? $basePath : '' ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= isset($basePath) ? $basePath : '' ?>index.php#about">About Us</a></li>
                <li class="nav-item"><a class="nav-link <?= activeClass($activePage ?? '', 'quiz'); ?>" href="<?= isLoggedIn() ? (isset($basePath) ? $basePath : '') . 'quiz.php' : (isset($basePath) ? $basePath : '') . 'auth/login.php'; ?>">Quiz</a></li>
                <li class="nav-item"><a class="nav-link <?= activeClass($activePage ?? '', 'contact'); ?>" href="<?= isset($basePath) ? $basePath : '' ?>contact.php">Contact</a></li>
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link <?= activeClass($activePage ?? '', 'dashboard'); ?>" href="<?= isset($basePath) ? $basePath : '' ?>dashboard.php">Dashboard</a></li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0"><a class="btn btn-secondary-custom" href="<?= isset($basePath) ? $basePath : '' ?>auth/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0"><a class="btn btn-primary-custom" href="<?= isset($basePath) ? $basePath : '' ?>auth/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
