<?php
// Get POST data
$data = json_decode($_POST['data'], true);

// Initialize variables for database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_maintenance";
$query="";
// Initialize an empty array for response
$response = array();

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the data
foreach ($data as $item) {
    $name = $item['name'];
    $quantity = $item['quantity'];
    $unitPrice = $item['amount'];
    $Amount = $item['amount'];
    $id = $item['id'];

    // Build the UPDATE query
    $query ="UPDATE stock_table SET quantity = quantity - $quantity WHERE id = $id ";


    // Execute the query
    if ($conn->query($query) === TRUE) {
        $response[] = array('message' => "Updated stock for item ID $id");
    } else {
        $response[] = array('message' => "Error updating stock for item ID $id: " . $conn->error);
    }
}


// Close the database connection
$conn->close();

// Send a JSON response
echo json_encode(array('message' => 'Data received and processed successfully', 'response' => $response));
?>