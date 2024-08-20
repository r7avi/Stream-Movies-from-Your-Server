<?php
// Check if the user is already logged in, redirect to another page if true
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Replace 'login.php' with the page you want to redirect to
    exit();
}

// Display error message if provided in the URL
$error = isset($_GET['error']) ? $_GET['error'] : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 50px;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        p.error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>User Registration</h2>
    <a href="../login.php" style="display: inline-block; background-color: #4caf50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; margin-top: 10px;">Home</a>
<br><br>
<form action="config/register_process.php" method="post" onsubmit="return validateForm()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
<label for="email">Email:</label>
<input type="email" id="email" name="email" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password (minimum 8 characters):</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>

        <?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error === 'username_taken') {
        echo '<p class="error">Username already taken. Please choose a different one.</p>';
    } elseif ($error === 'email_taken') {
        echo '<p class="error">Email already taken. Please use a different one.</p>';
    } elseif ($error === 'database_error') {
        echo '<p class="error">Error in database insertion. Please try again later.</p>';
    }
}
?>
    </form>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;

            if (password.length < 8) {
                alert("Password must be at least 8 characters long.");
                return false;
            }

            return true;
        }

        // Function to clear all form fields after 1 second
        function clearFormFields() {
            // Your existing clearFormFields function remains unchanged
        }

        // Call the function when the document is fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            clearFormFields();
        });
    </script>
</body>
</html>
