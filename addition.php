<?php
// Check if the form data has been sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Database connection parameters
    $servername = "localhost";  // Replace with your actual database server name
    $username = "root";         // Replace with your actual database username
    $password = "";             // Replace with your actual database password
    $dbname = "stock_maintenance";          // Replace with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle file upload
    $uploadDirectory = "uploads/"; // Directory to save uploaded images
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

    // Generate a new filename based on the current date and time
    $newFileName = date('YmdHis') . '.' . $imageFileType;


    $uploadFile = $newFileName;

    // Check if file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/".$uploadFile)) {
            echo "The file ". htmlspecialchars($newFileName). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Prepare SQL query to insert data into your table
    $stmt = $conn->prepare("INSERT INTO stock_table (name, id, `date-received`, `expiry-date`, amount, quantity, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Bind parameters with form data
    $stmt->bind_param("sssssss", $name, $id, $date_received, $expiry_date, $amount, $quantity, $imagePath);

    // Set parameters from POST data
    $name = $_POST['name'];
    $id = $_POST['id'];
    $date_received = $_POST['date-received'];
    $expiry_date = $_POST['expiry-date'];
    $amount = $_POST['amount'];
    $quantity = $_POST['quantity'];
    $imagePath = $uploadFile; // Store the path of the uploaded file

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record inserted successfully";
echo $uploadOk;

    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not POST, return an error
    echo "Error: POST method not detected";
}
?>