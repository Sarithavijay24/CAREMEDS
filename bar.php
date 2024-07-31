<?php
// Database configuration
$host = 'localhost';
$dbname = 'stock_maintenance';
$user = 'root';
$pass = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define the query
    $query = 'SELECT name, quantity FROM stock_table'; // Adjust table and column names as needed

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all results
    $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results as JSON
    header('Content-Type: application/json');
    echo json_encode($stocks);

} catch (PDOException $e) {
    // Handle database connection errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>

