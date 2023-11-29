<?php
// Establish a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ps";

// Retrieve the app name from the URL parameter
$appName = $_GET['app_name'] ?? '';

// Create an empty array to store the response data
$response = array();

// Create a new MySQLi object
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($appName)) {
    // Prepare and execute the query to fetch the star rating and number of downloads
    $query = "SELECT rating, downloads FROM app_data WHERE app_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $appName);
    $stmt->execute();
    $stmt->store_result();

    // Check if the app exists in the database
    if ($stmt->num_rows > 0) {
        // Bind the result to variables
        $stmt->bind_result($rating, $downloads);

        // Fetch the result
        $stmt->fetch();

        // Assign the retrieved data to the response array
        $response['rating'] = $rating;
        $response['downloads'] = $downloads;
    } else {
        // If the app does not exist, assign N/A to the response array
        $response['rating'] = "N/A";
        $response['downloads'] = "N/A";
    }

    // Close the statement
    $stmt->close();
} else {
    // If the app name is empty, assign N/A to the response array
    $response['rating'] = "N/A";
    $response['downloads'] = "N/A";
}

// Close the database connection
$conn->close();

// Return the data as a JSON response
echo json_encode($response);
?>