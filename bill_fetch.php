<?php
// Database configuration (replace with your actual database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock_maintenance";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve barcode from GET request
if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];

    // Prepare SQL statement to fetch product details based on barcode
    $sql = "SELECT * FROM stock_table WHERE id = '$barcode'";
    $result = $conn->query($sql);

    if ($result === false) {
        // Handle query error
        die("Error executing query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Product found, fetch details
        $row = $result->fetch_assoc();
        
        // Assuming quantity is provided as a parameter (adjust this part as per your implementation)
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1; // Default to 1 if quantity is not provided

        // Fetch unit_price from database
        $unitPrice = $row['amount'];

        // Calculate amount based on unit_price and quantity
        $amount = $unitPrice * $quantity;

        // Construct product details array
        $productDetails = array(
            'name' => $row['name'],
            'unitPrice' => $unitPrice,
            'amount' => $amount,
            'id' => $barcode
        );

        echo json_encode($productDetails);
    } else {
        // Product not found
        echo json_encode(array('name' => 'Unknown', 'unitPrice' => 0, 'amount' => 0, 'id' => 0));
    }
} else {
    // Barcode not provided
    echo json_encode(array('name' => 'Unknown', 'unitPrice' => 0, 'amount' => 0, 'id' => 0));
}

$conn->close();
?>
