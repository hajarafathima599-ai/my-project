<?php
$pageTitle = 'Quizify - Interactive Quiz Web Application';
$activePage = 'home';
$basePath = '';
require_once __DIR__ . '/includes/header.php';
?>
<main>
    <section class="hero-section text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="hero-title">Interactive Quiz System</h1>
                    <p class="hero-subtitle">Test your knowledge through interactive quizzes. Register, login, attempt the quiz, and save your score in the database.</p>
                    <a href="<?= isLoggedIn() ? 'quiz.php' : 'auth/register.php'; ?>" class="btn btn-primary-custom btn-lg">Start Quiz <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="images/hero_banner.png" alt="Students studying together" class="img-fluid hero-image">
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-5 my-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-3">About Quizify</h2>
                    <p class="text-muted fs-5">Quizify is an interactive web application designed to help students test and improve their knowledge through engaging quizzes in a clean and responsive environment.</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-laptop feature-icon"></i>
                        <h3 class="feature-title">Interactive Learning</h3>
                        <p class="feature-desc">Students can sign in securely and take quizzes with a smooth user experience.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-clipboard2-check feature-icon"></i>
                        <h3 class="feature-title">Knowledge Testing</h3>
                        <p class="feature-desc">Multiple-choice questions test HTML, CSS, JavaScript, C++, Java, and Python basics.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-graph-up-arrow feature-icon"></i>
                        <h3 class="feature-title">Score Tracking</h3>
                        <p class="feature-desc">After each quiz, the result is saved in MySQL and displayed in the dashboard history.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
