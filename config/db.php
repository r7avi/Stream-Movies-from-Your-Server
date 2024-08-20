<?php
$servername = "localhost";
$username = "ktmr_movies";
$password = "^gIpheoPdxpGDjpI";
$dbname = "ktmr_movies";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
