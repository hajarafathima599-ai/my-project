# my-project
 # Quizify - Phase 03 Backend Project

## Technologies Used
- HTML
- CSS
- Bootstrap
- JavaScript
- PHP
- MySQL
- WAMP Server

---

## Project Description
Quizify is an interactive web application developed as part of Phase 03.  
This project integrates PHP and MySQL to implement backend functionality such as user authentication, quiz result storage, and contact form handling.

---

## Folder Structure
- `includes/db.php` - Database connection file
- `includes/functions.php` - Helper functions and session handling
- `auth/register.php` - User registration page
- `auth/login.php` - User login page
- `auth/logout.php` - Logout logic
- `contact.php` - Contact form with database storage
- `dashboard.php` - User dashboard with quiz result history
- `quiz.php` - Quiz page
- `submit_quiz.php` - Stores quiz results in database
- `result.php` - Displays quiz result
- `quizify_db.sql` - MySQL database export file

---

## Setup Instructions (WAMP)

### 1. How to Import the Database

1. Open your browser  
2. Go to: http://localhost/phpmyadmin

3. Click on **Import** tab  
4. Click **Choose File**  
5. Select: quizify_db.sql

6. Click **Go**

This will automatically:
- Create database `quizify_db`
- Create tables (`users`, `messages`, `quiz_results`)

---

### 2. How to Run the Project using WAMP

#### Step 1: Copy Project Folder
Copy the project folder into:
C:\wamp64\www\


Example:
C:\wamp64\www\MY-PROJECT


---

#### Step 2: Start WAMP Server
- Open WAMP Server
- Ensure the WAMP icon turns **GREEN** (Apache + MySQL running)

---

#### Step 3: Open the Project

Open in browser:
http://localhost/MY-PROJECT/


---

## Default Database Configuration
- Host: `localhost`
- User: `root`
- Password: (empty)
- Database: `quizify_db`

---

## Features Implemented
- User registration using `password_hash()`
- User login using `password_verify()`
- Session-based authentication
- Logout functionality
- Protected pages (only logged-in users)
- Contact form with database storage
- Quiz system with score calculation
- Quiz result saving to database
- Dashboard with quiz history

---