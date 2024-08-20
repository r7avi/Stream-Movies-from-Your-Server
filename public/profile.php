<?php
session_start();

// Include the database connection
include '../config/db.php';

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch the user's profile information
$username = $_SESSION['username'];
$fetchProfileQuery = "SELECT name, email FROM users WHERE username = '$username'";
$result = $conn->query($fetchProfileQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentName = $row['name'];
    $currentEmail = $row['email'];
} else {
    // Handle the error (you might want to add more robust error handling)
    echo "Error fetching profile information: " . $conn->error;
    exit();
}

// Handle form submission to update user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateName'])) {
        $newName = $_POST['name'];

        // Ensure that the username is non-editable
        $username = $_SESSION['username'];

        // Update the name in the database
        $updateNameQuery = "UPDATE users SET name = '$newName' WHERE username = '$username'";
        if ($conn->query($updateNameQuery) !== TRUE) {
            // Handle the error (you might want to add more robust error handling)
            echo "Error updating name: " . $conn->error;
            exit();
        }

        // Manually update the session variable
        $_SESSION['name'] = $newName;

        // Redirect back to profile page after updating
        header("Location: ../public/profile.php");
        exit();
    } elseif (isset($_POST['updatePassword'])) {
        $newPassword = $_POST['password'];

        // Ensure that the username is non-editable
        $username = $_SESSION['username'];

        // Update the password in the database (hashed)
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE users SET password = '$hashedPassword' WHERE username = '$username'";
            if ($conn->query($updatePasswordQuery) !== TRUE) {
                // Handle the error (you might want to add more robust error handling)
                echo "Error updating password: " . $conn->error;
                exit();
            }
        }

        // Redirect back to profile page after updating
        header("Location: ../public/profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        /* styles.css */

        .container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .profile-info {
            text-align: left;
        }

        .profile-field {
            margin-bottom: 10px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .submit-btn {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<!-- Include the header -->
<?php include '../public/header.php'; ?>

<div class="container">

    <div class="profile-info">
        <h1>User Profile</h1>

        <div class="profile-field">
            <label for="username">Username:</label>
            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <br>

        <div class="profile-field">
            <label for="email">Email:</label>
            <span><?php echo htmlspecialchars($currentEmail); ?></span>
        </div>
        <br>

        <div class="profile-field" id="nameField">
            <div id="nameDisplay">
                <label for="name">Name:</label>
                <span id="nameValue"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                <a href="javascript:void(0);" onclick="enableEdit('name')">edit name</a>
            </div>
            <form id="nameForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: none;">
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($currentName); ?>">
                <input type="submit" name="updateName" value="Update" class="submit-btn">
            </form>
        </div>

        <br>

        <div class="profile-field" id="passwordField">
            <div id="passwordDisplay">
                <label for="password">Password:</label>
                <span id="passwordValue">********</span>
                <a href="javascript:void(0);" onclick="enableEdit('password')">change password</a>
            </div>
            <form id="passwordForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: none;">
                <input type="password" id="password" name="password" placeholder="Leave blank to keep the same password">
                <input type="submit" name="updatePassword" value="Update" class="submit-btn">
            </form>
        </div>
        <br>
    </div>

</div>

<script>
    function enableEdit(field) {
        const formElement = document.getElementById(`${field}Form`);
        const displayElement = document.getElementById(`${field}Display`);
        const fieldValueElement = document.getElementById(`${field}Value`);
        const editLink = document.querySelector(`#${field}Display a`);

        // Hide the display element and show the form element
        displayElement.style.display = 'none';
        formElement.style.display = 'block';

        // If it's the password field, focus on the password input
        if (field === 'password') {
            const passwordInput = document.getElementById('password');
            passwordInput.style.display = 'block';
            passwordInput.focus();
        }

        // Hide the edit link
        editLink.style.display = 'none';
    }
</script>

<!-- Include the footer -->
<?php include '../public/footer.php'; ?>

</body>
</html>
