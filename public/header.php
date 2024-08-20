<!-- header.php -->

<?php


include_once($_SERVER['DOCUMENT_ROOT'] . "/config/db.php");

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Check if the login time is set in the session
    if (isset($_SESSION['login_time'])) {
        // Define the session timeout duration (1 hour in seconds)
        $session_timeout = 14400; // 1 hour = 60 seconds * 60 minutes

        // Get the current time
        $current_time = time();

        // Calculate the time difference
        $time_difference = $current_time - $_SESSION['login_time'];

        // If the time difference exceeds the session timeout, log the user out
        if ($time_difference > $session_timeout) {
            // Destroy the session
            session_unset();
            session_destroy();

            // Redirect to the login page or any other desired page
            header("Location: ../login.php");
            exit();
        }
    }
}

// Update the login time in the session on each page load
$_SESSION['login_time'] = time();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../config/style.css?v=<?= filemtime('../config/style.css') ?>">
    <link rel="icon" href="../assets/icon.png" type="image/png">
    <title>Private Movie Server</title>

</head>
<body>

<header>
    <div class="logo">
        <a href="../index.php">
    <img src="../assets/logo4.webp" alt="Logo" style="width: 120px; height: auto;" class="logo">
</a>

    </div>
    <nav>
        <ul>

            <li><a href="../index.php">Home</a></li>

            <!-- Add more menu items as needed -->
             <?php
        if (isset($_SESSION['username'])) {
            echo '<li><a href="profile.php">Profile</a></li>';
        }
        ?>
            <?php
            // Display the logout link if the user is authenticated
            if (isset($_SESSION['username'])) {
                echo '<li><a href="dashboard.php?logout">Logout</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
