<?php
// Start or resume the session
session_start();

include '../config/db.php';

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the login page or any other page as needed
    header("Location: ../login.php");
    exit();
}

// Process movie request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["movie_request"])) {
        // Assuming you have a session variable storing the logged-in username
        $username = $_SESSION["username"];
        $movieTitle = $_POST["movie_title"];

        // Insert request into the 'requests' table
        $sql = "INSERT INTO requests (username, movie_title) VALUES ('$username', '$movieTitle')";
        if ($conn->query($sql) === TRUE) {
            echo "Request Submitted Successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Display last 10 movie requests (latest first)
$sql = "SELECT * FROM requests ORDER BY request_date DESC LIMIT 10";
$result = $conn->query($sql);

// Include header
include('../public/header.php');
?>

<!-- CSS Style -->
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
        background-color: #f4f4f4;
    }

    h2, h3 {
        color: #333;
    }

    /* Style specific to the page's ul */
    #movie-requests-list {
        list-style-type: none;
        padding: 0;
    }

    #movie-requests-list li {
        background-color: #fff;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    form {
        margin-top: 20px;
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"] {
        width: 300px;
        padding: 5px;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

</style>

<!-- Movie request form -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="movie_title"><h2>Request a Movie / Series</h2></label>
    <input type="text" name="movie_title" required><br>

    <input type="submit" name="movie_request" value="Submit Request">
</form>

<h3>Requested Movies</h3>
<!-- Use a specific id for the ul in this page -->
<ul id="movie-requests-list">
    <?php
    while ($row = $result->fetch_assoc()) {
        // Convert timestamp to Indian time zone and format
        $requestDate = new DateTime($row['request_date'], new DateTimeZone('UTC'));
        $requestDate->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formattedDate = $requestDate->format('d-M-Y h:i A');

        echo "<li>{$row['username']} requested '{$row['movie_title']}' on {$formattedDate}</li>";
    }
    ?>
</ul>

<?php
// Include footer
include('../public/footer.php');

$conn->close();
?>
