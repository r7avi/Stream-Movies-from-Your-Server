<?php
$servername = "localhost";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_PASSWORD";
$dbname = "YOUR_DB_NAME";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
//PLEASE CREATE DB AND IMPORT DATA FROM database.sql FILE
