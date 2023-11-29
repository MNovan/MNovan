<?php
// Get the app name and download count from the request parameters
$appName = $_GET['app_name'];
$downloadCount = $_GET['download_count'];

// Update the download count in the database
// Replace this with your actual code to update the database
// Example: Assuming you have a database connection established
// and a table named 'apps' with columns 'app_name' and 'download_count'

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ps";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the download count for the given app name
$sql = "UPDATE app_data SET downloads = '$downloadCount' WHERE app_name = '$appName'";

if ($conn->query($sql) === TRUE) {
    echo "Download count updated successfully";
} else {
    echo "Error updating download count: " . $conn->error;
}

$conn->close();
?>