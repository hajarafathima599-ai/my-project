<?php
require_once __DIR__ . '/includes/functions.php';
requireLogin();
$pageTitle = 'Quiz in Progress - Quizify';
$activePage = 'quiz';
$basePath = '';
require_once __DIR__ . '/includes/header.php';
?>
<main class="d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="quiz-card p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-primary" id="quizTitle">General Knowledge</h4>
                        <div class="progress-indicator mb-0" id="progressIndicator">Question 1 of 5</div>
                    </div>
                    <div class="progress mb-4" style="height: 10px;">
                        <div class="progress-bar bg-primary" id="progressBar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div id="questionContainer">
                        <h5 class="fw-bold mb-4" id="questionText">Loading question...</h5>
                        <div id="optionsContainer"></div>
                    </div>
                    <div id="quizAlert" class="alert alert-danger d-none mt-3" role="alert">Please select an answer before proceeding to the next question.</div>
                    <div class="d-flex justify-content-between mt-4">
                        <button id="prevBtn" class="btn btn-outline-secondary px-4 d-none">Previous</button>
                        <button id="nextBtn" class="btn btn-primary-custom px-5 ms-auto">Next <i class="bi bi-chevron-right ms-1"></i></button>
                        <button id="submitBtn" class="btn btn-success px-5 ms-auto d-none">Submit Quiz <i class="bi bi-check-circle ms-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
