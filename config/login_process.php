<?php
// config/login_process.php

// Enable error reporting for this script
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once($_SERVER['DOCUMENT_ROOT'] . "/config/db.php");
session_start();

// Set the default timezone to Asia/Kolkata (GMT +5:30)
//date_default_timezone_set('Asia/Kolkata');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Fetch the stored hashed password and name from the database based on the username
    $checkLoginQuery = "SELECT id, username, password, name FROM users WHERE username = '$username'";
    $result = $conn->query($checkLoginQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];  // Move the userId assignment here

        // Verify the entered password against the stored hash
        if (password_verify($enteredPassword, $row["password"])) {
            // Login successful, set session and redirect to dashboard
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];  // Store the user's name in the session

            // Update the login_history table with the login information
            $currentDateTime = date('Y-m-d H:i:s');
            $insertLoginQuery = "INSERT INTO login_history (username, login_time) VALUES ('$username', '$currentDateTime')";

            if ($conn->query($insertLoginQuery) === TRUE) {
                // Success
                header("Location: ../public/dashboard.php");
                exit();
            } else {
                // Error in executing query
                echo "Error updating login history: " . $conn->error;
                exit();
            }
        } else {
            // Invalid login, handle accordingly (e.g., redirect to login page with an error message)
            header("Location: ../login.php?error=invalid_login");
            exit();
        }
    } else {
        // User not found, handle accordingly (e.g., redirect to login page with an error message)
        header("Location: ../login.php?error=user_not_found");
        exit();
    }
} else {
    // Invalid request, handle accordingly (e.g., redirect to login page)
    header("Location: ../login.php");
    exit();
}

$conn->close();
?>
