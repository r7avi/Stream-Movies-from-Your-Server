<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

session_start();

// Check if the user is already logged in, redirect to another page if true
if (isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Replace 'welcome.php' with the page you want to redirect to
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $email = $_POST["email"];

    // Check if the username is already taken
    $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
    $stmtUsername = $conn->prepare($checkUsernameQuery);
    $stmtUsername->bind_param("s", $username);
    $stmtUsername->execute();
    $resultUsername = $stmtUsername->get_result();

    if ($resultUsername->num_rows > 0) {
        // Username already exists, handle accordingly (e.g., redirect to registration page with an error message)
        header("Location: ../register.php?error=username_taken");
        exit();
    }

    // Check if the email is already taken
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmtEmail = $conn->prepare($checkEmailQuery);
    $stmtEmail->bind_param("s", $email);
    $stmtEmail->execute();
    $resultEmail = $stmtEmail->get_result();

    if ($resultEmail->num_rows > 0) {
        // Email already exists, handle accordingly (e.g., redirect to registration page with an error message)
        header("Location: ../register.php?error=email_taken");
        exit();
    }

    // Insert user into the database
    $insertUserQuery = "INSERT INTO users (name, username, password, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertUserQuery);
    $stmt->bind_param("ssss", $name, $username, $password, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // User registered successfully, redirect to login page
        header("Location: ../login.php?success=registration_successful");
        exit();
    } else {
        // Error in database insertion, handle accordingly (e.g., redirect to registration page with an error message)
        header("Location: ../register.php?error=database_error");
        exit();
    }
} else {
    // Invalid request, handle accordingly (e.g., redirect to registration page)
    header("Location: ../register.php");
    exit();
}

$conn->close();
?>
