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

// Your other login process logic goes here

// Simulate an error for demonstration purposes
if (isset($_GET['simulate_error'])) {
    header("Location: login.php?error=user_not_found");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KTM Racing!</title>
    <style>
     
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Comic Sans MS", cursive;
}
body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #111;
  width: 100%;
  overflow: hidden;
  overflow-x: hidden; /* Prevent horizontal overflow */
}
     
    
.ring {
  position: relative;
  width: 400px;
  height: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.ring i {
  position: absolute;
  inset: 0;
  border: 2px solid #fff;
  transition: 0.5s;
}
.ring i:nth-child(1) {
  border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
  animation: animate 6s linear infinite;
}
.ring i:nth-child(2) {
  border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
  animation: animate 4s linear infinite;
}
.ring i:nth-child(3) {
  border-radius: 41% 44% 56% 59%/38% 62% 63% 37%;
  animation: animate2 10s linear infinite;
}
.ring:hover i {
  border: 6px solid var(--clr);
  filter: drop-shadow(0 0 20px var(--clr));
}
@keyframes animate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes animate2 {
  0% {
    transform: rotate(360deg);
  }
  100% {
    transform: rotate(0deg);
  }
}
.login {
  position: absolute;
  width: 300px;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 20px;
}
.login h2 {
  font-size: 2em;
  color: #fff;
}
.login .inputBx {
  position: relative;
  width: 100%;
  margin-top: 10px;
}
.login .inputBx input {
  position: relative;
  width: 100%;
  padding: 12px 26px;
  background: transparent;
  border: 2px solid #fff;
  border-radius: 40px;
  font-size: 1.2em;
  color: #fff;
  box-shadow: none;
  outline: none;
}
.login .inputBx input[type="submit"] {
  width: 100%;
  background: #0078ff;
  background: linear-gradient(45deg, #ff357a, #fff172);
  border: none;
  cursor: pointer;
}
.login .inputBx input::placeholder {
  color: rgba(255, 255, 255, 0.75);
}
.login .links {
  position: relative;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
}
.login .links a {
  color: #fff;
  text-decoration: none;
}

  </style>
</head>
<body>


<!--ring div starts here-->
<div class="ring">
  <i style="--clr:#00ff0a;"></i>
  <i style="--clr:#ff0057;"></i>
  <i style="--clr:#fffd44;"></i>
  <div class="login">
    <h2>Namaskara</h2>
    <!-- Add the form element with the action attribute set to form.php and method attribute set to POST -->
    <form action="/config/login_process.php" method="POST">
      <div class="inputBx">
        <!-- Add a name attribute to identify the input field when submitted -->
        <input type="text" name="username" placeholder="Username">
      </div>
      <div class="inputBx">
        <!-- Add a name attribute to identify the input field when submitted -->
        <input type="password" name="password" placeholder="Password">
      </div>
      <div class="inputBx">
        <input type="submit" value="Sign in">
      </div>
      <div class="inputBx" style="display: flex; justify-content: center;">
        <!-- Use an anchor element for registration with adjusted styling -->
        <a href="register.php" style="background: #0078ff; background: linear-gradient(45deg, #ff357a, #fff172); border-radius: 30px;border: none; cursor: pointer; text-align: center; text-decoration: none; color: #fff; display: inline-block; padding: 12px;">Register</a>
    </div>
    </form>
  <!-- <div class="links">
      <a href="#">Forget Password</a>
      <a href="#">Signup</a>
    </div>-->
  </div>
</div>
<!--ring div ends here-->

<script>
    // You can keep your existing JavaScript for other purposes, if any
    function validateForm() {
        // Add any client-side validation if needed
        return true; // Allow form submission
    }

    // Display error in a popup and redirect to login page
    <?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        if ($error === 'invalid_login') {
            echo 'alert("Incorrect username or password.");';
        } elseif ($error === 'user_not_found') {
            echo 'alert("User not found.");';
        }

        // Redirect to login page after displaying the alert
        echo 'setTimeout(function(){ window.location.href = "login.php"; }, 100);'; // 1000 milliseconds (1 second) delay
    }
    ?>
</script>
<script>
    // Function to clear all form fields after 1 second
    function clearFormFields() {
        setTimeout(function () {
            // Get all form elements
            var form = document.querySelector('form');
            var formElements = form.elements;

            // Loop through each form element and clear the value
            for (var i = 0; i < formElements.length; i++) {
                var element = formElements[i];

                // Exclude buttons, hidden fields, and the "Sign in" button from being cleared
                if (element.type !== 'button' && element.type !== 'hidden' && element.value !== 'Sign in') {
                    element.value = '';
                }
            }
        }, 1000); // 1000 milliseconds = 1 second
    }

    // Call the function when the document is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        clearFormFields();
    });
</script>

</body>
</html>
