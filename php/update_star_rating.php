<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ps";

// Get the app name and star rating from the query parameters
$appName = $_GET['app_name'];
$starRating = $_GET['star_rating'];

// Limit the star rating to a maximum of 5
$starRating = min($starRating, 5);

// Connect to the database
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Escape the input to prevent SQL injection
$appName = $mysqli->real_escape_string($appName);
$starRating = $mysqli->real_escape_string($starRating);

// Update the star rating in the database
$query = "UPDATE app_data SET rating = '$starRating' WHERE app_name = '$appName'";
$result = $mysqli->query($query);

// Check if the update was successful
if ($result) {
    echo "Star rating updated successfully.";
} else {
    echo "Error updating star rating: " . $mysqli->error;
}

// Close the database connection
$mysqli->close();
?>