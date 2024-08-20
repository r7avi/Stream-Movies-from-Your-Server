<?php
// login_process.php

// Enable error reporting for this script
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Custom error handler function
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px;'>";
    echo "<strong>Error:</strong> [$errno] $errstr<br>";
    echo "Error on line $errline in file $errfile<br>";
    echo "</div>";
}

// Set custom error handler
set_error_handler("customErrorHandler");




// Start or resume the session
session_start();

// If the user is already logged in, redirect to the dashboard
if (isset($_SESSION['username'])) {
    header("Location: public/dashboard.php"); // Adjust the path based on your actual dashboard page location
    exit();
}



// Include the header
include 'public/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        
.maincontainer {
    font-family: "Comic Sans MS", cursive;
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 15vh;
}
.container {
margin-top: 2%;
  width: 100%;
  max-width: 380px;
  margin-top:20px;
  margin-right:40px;
}

.card {
  width: 100%;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
 
}

h2 {
  text-align: center;
  color: #333;
}

form {
  display: flex;
  flex-direction: column;
}

input {
  padding: 10px;
  margin-bottom: 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  transition: border-color 0.3s ease-in-out;
  outline: none;
  color: #333;
}

input:focus {
  border-color: #ff4500;
}

button {
  background-color: #ff4500;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

button:hover {
  background-color: #e63900;
}

        </style>
</head>

<body>

<div class="maincontainer">
<div class="container">
  <div class="card">
    <h2>Namaste!</h2>
    <form action="config/login_process.php" method="post">
      <input type="text" id="username" name="username" placeholder="Username" required>
      <input type="password" id="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
     
    </form>

    <br>
       <!-- Display error messages here -->
            <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    if ($error === 'invalid_login') {
                        echo '<p style="color: red;text-align: center;">Incorrect username or password.</p>';
                    } elseif ($error === 'user_not_found') {
                        echo '<p style="color: red;text-align: center;">User not found.</p>';
                    }
                    // Redirect to login.php after 5 seconds
            echo '<meta http-equiv="refresh" content="5;url=login.php" />';
                }
            ?>
    
  </div>
</div></div>

<script>
    // You can keep your existing JavaScript for other purposes, if any
    function validateForm() {
        // Add any client-side validation if needed
        return true; // Allow form submission
    }
</script>
</body>

<?php
// Include the footer
include 'public/footer.php';
?>

