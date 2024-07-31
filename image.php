<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_maintenance";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch image data
$sql = "SELECT id, name, image FROM stock_table";
$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($images);

$conn->close();
?>