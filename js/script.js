// Quizify State & Auth Management

// Ensure user identity is known across navigation
document.addEventListener("DOMContentLoaded", () => {
    updateNavigation();
    setupLoginHandler();
    checkAuthForQuiz();
});

function updateNavigation() {
    const username = sessionStorage.getItem("quizify_user");
    const loginBtn = document.getElementById("nav-login-btn");
    const quizLink = document.getElementById("nav-quiz-link");

    if (quizLink) {
        quizLink.addEventListener("click", (e) => {
            if (!sessionStorage.getItem("quizify_user")) {
                e.preventDefault();
                window.location.href = "login.html";
            } else {
                e.preventDefault();
                window.location.href = "quiz.html";
            }
        });
    }

    if (username && loginBtn) {
        loginBtn.textContent = "Logout";
        loginBtn.classList.remove("btn-primary-custom");
        loginBtn.classList.add("btn-secondary-custom");
        loginBtn.href = "#";
        loginBtn.addEventListener("click", (e) => {
            e.preventDefault();
            sessionStorage.removeItem("quizify_user");
            sessionStorage.removeItem("quizify_score");
            window.location.href = "index.html";
        });
    }
}

function setupLoginHandler() {
    const loginForm = document.getElementById("loginForm");
    if (!loginForm) return;

    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("password");
        const usernameError = document.getElementById("usernameError");
        const passwordError = document.getElementById("passwordError");
        const loginAlert = document.getElementById("loginAlert");

        // Reset errors
        usernameInput.classList.remove("is-invalid");
        passwordInput.classList.remove("is-invalid");
        usernameError.classList.add("d-none");
        passwordError.classList.add("d-none");
        loginAlert.classList.add("d-none");

        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();

        let isValid = true;

        if (!username) {
            usernameInput.classList.add("is-invalid");
            usernameError.classList.remove("d-none");
            isValid = false;
        }

        if (!password) {
            passwordInput.classList.add("is-invalid");
            passwordError.classList.remove("d-none");
            isValid = false;
        }

        if (isValid) {
            // Fake auth success -> Redirect
            sessionStorage.setItem("quizify_user", username);
            window.location.href = "quiz.html";
        } else {
            loginAlert.classList.remove("d-none");
        }
    });
}

function checkAuthForQuiz() {
    // If the current page is quiz or result, enforce auth
    const currentPath = window.location.pathname;
    if (currentPath.endsWith("quiz.html") || currentPath.endsWith("result.html")) {
        if (!sessionStorage.getItem("quizify_user")) {
            window.location.replace("login.html");
        }
    }
}

// ----------------------------------------------------
// QUIZ LOGIC
// ----------------------------------------------------

const quizData = [
    {
        question: "What does HTML stand for?",
        options: [
            "Hyper Text Preprocessor",
            "Hyper Text Markup Language",
            "Hyper Text Multiple Language",
            "Hyper Tool Multi Language"
        ],
        correct: 1
    },
    {
        question: "What does CSS stand for?",
        options: [
            "Common Style Sheet",
            "Colorful Style Sheet",
            "Computer Style Sheet",
            "Cascading Style Sheet"
        ],
        correct: 3
    },
    {
        question: "Which technology is used primarily for adding interactivity to a webpage?",
        options: [
            "HTML",
            "CSS",
            "Python",
            "JavaScript"
        ],
        correct: 3
    },
    {
        question: "Which of the following is a CSS framework?",
        options: [
            "React",
            "Bootstrap",
            "Django",
            "Laravel"
        ],
        correct: 1
    },
    {
        question: "How do you declare a JavaScript variable?",
        options: [
            "var name;",
            "variable name;",
            "v name;",
            "declare name;"
        ],
        correct: 0
    }
];

let currentQuestion = 0;
let userAnswers = [];

function initQuiz() {
    const questionContainer = document.getElementById("questionContainer");
    if (!questionContainer) return; // Not on quiz page

    // Initialize empty answers array
    userAnswers = new Array(quizData.length).fill(null);
    currentQuestion = 0;

    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");
    const submitBtn = document.getElementById("submitBtn");

    if (nextBtn) {
        nextBtn.addEventListener("click", handleNext);
    }
    if (prevBtn) {
        prevBtn.addEventListener("click", handlePrev);
    }
    if (submitBtn) {
        submitBtn.addEventListener("click", handleSubmit);
    }

    loadQuestion();
}

function loadQuestion() {
    const questionText = document.getElementById("questionText");
    const optionsContainer = document.getElementById("optionsContainer");
    const progressIndicator = document.getElementById("progressIndicator");
    const progressBar = document.getElementById("progressBar");
    const quizAlert = document.getElementById("quizAlert");

    // Hide error alert when loading new question
    quizAlert.classList.add("d-none");

    const data = quizData[currentQuestion];

    // Update texts
    questionText.textContent = `${currentQuestion + 1}. ${data.question}`;
    progressIndicator.textContent = `Question ${currentQuestion + 1} of ${quizData.length}`;

    // Update progress bar
    const progressPercent = ((currentQuestion + 1) / quizData.length) * 100;
    progressBar.style.width = `${progressPercent}%`;
    progressBar.setAttribute("aria-valuenow", progressPercent);

    // Clear previous options
    optionsContainer.innerHTML = "";

    // Render options
    data.options.forEach((opt, index) => {
        const btn = document.createElement("button");
        btn.className = "quiz-option";
        btn.textContent = opt;

        // Restore selected state if navigating back
        if (userAnswers[currentQuestion] === index) {
            btn.classList.add("selected");
        }

        btn.addEventListener("click", () => selectOption(index, btn));
        optionsContainer.appendChild(btn);
    });

    updateNavigationButtons();
}

function selectOption(index, buttonElement) {
    // Save to state
    userAnswers[currentQuestion] = index;

    // Update UI visually
    const allOptions = document.querySelectorAll(".quiz-option");
    allOptions.forEach(opt => opt.classList.remove("selected"));
    buttonElement.classList.add("selected");

    // Hide alert if visible
    document.getElementById("quizAlert").classList.add("d-none");
}

function handleNext() {
    if (userAnswers[currentQuestion] === null) {
        // Show error if nothing is selected
        document.getElementById("quizAlert").classList.remove("d-none");
        return;
    }

    if (currentQuestion < quizData.length - 1) {
        currentQuestion++;
        loadQuestion();
    }
}

function handlePrev() {
    if (currentQuestion > 0) {
        currentQuestion--;
        loadQuestion();
    }
}

function handleSubmit() {
    if (userAnswers[currentQuestion] === null) {
        // Show error if nothing is selected
        document.getElementById("quizAlert").classList.remove("d-none");
        return;
    }

    // Calculate score
    let score = 0;
    for (let i = 0; i < quizData.length; i++) {
        if (userAnswers[i] === quizData[i].correct) {
            score++;
        }
    }

    // Save score to session
    sessionStorage.setItem("quizify_score", score);
    sessionStorage.setItem("quizify_total", quizData.length);

    // Redirect to Result page
    window.location.href = "result.html";
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const submitBtn = document.getElementById("submitBtn");

    if (currentQuestion === 0) {
        prevBtn.classList.add("d-none");
    } else {
        prevBtn.classList.remove("d-none");
    }

    if (currentQuestion === quizData.length - 1) {
        nextBtn.classList.add("d-none");
        submitBtn.classList.remove("d-none");
    } else {
        nextBtn.classList.remove("d-none");
        submitBtn.classList.add("d-none");
    }
}
