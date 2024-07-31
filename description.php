<?php
header('Content-Type: application/json');

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

$id = intval($_GET['id']);

$sql = "SELECT * FROM stock_table WHERE id = $id";
$result = $conn->query($sql);

$response = array('success' => false);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = array(
        'success' => true,
        'id' => $row['id'],
        'name' => $row['name'],
        'date_received' => $row['date-received'],
        'expiry_date' => $row['expiry-date'],
        'amount' => $row['amount'],
        'quantity' => $row['quantity']
    );
}

$conn->close();

echo json_encode($response);
?>
