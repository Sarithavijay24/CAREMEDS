<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Stock Maintenance Records</title>
    <!-- Link to Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f7f4; /* Light greenish-blue background */
            color: #026c0c3; /* Dark blue text */
            background-image: url('file:///C:/Users/umama/OneDrive/Pictures/Saved%20Pictures/2.jpg'); /* Path to your background image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
        }
        /* Header styles */
        header {
            background-color: #1fa7c2; /* Teal */
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 60px; /* Adjust height as needed */
        }
        nav ul {
            list-style-type: none;
            display: flex;
        }
        
        nav ul li {
            margin-right: 20px;
        }
        
        nav ul li a {
            text-decoration: none;
            color: #fff; /* White text color */
            font-weight: bold;
            padding: 10px;
            transition: background-color 0.3s ease;
        }
        
        nav ul li a:hover {
            background-color: #1c7e91; /* Darker teal on hover */
        }
        
        .dropdown {
            position: relative;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #1fa7c2; /* Dark teal */
            min-width: 160px;
            z-index: 1;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-content a {
            color: #fff; /* White text color */
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }
        
        .dropdown-content a:hover {
            background-color: #1c7e91; /* Darker teal on hover */
        }
        /* Container styles */
        .container {
            max-width: 800px; /* Adjusted for wider display */
            margin: 20px auto;
            background-color: #ffffff; /* White */
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            box-sizing: border-box;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff; /* White */
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #aac4ce; /* Light blue-gray */
        }

        th {
            background-color: #1fa7c2; /* Teal */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #ffffff; 
        }

        tr:hover {
            background-color: #c8e1e3; /* Light teal on hover */
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #1fa7c2; /* Teal */
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .pagination a.active {
            background-color: #1fa7c2; /* Teal */
            color: white;
        }

        .pagination a:hover:not(.active) {
            background-color: #f0f0f0; /* Light gray on hover */
        }

        /* Search bar styles */
        .search-container {
            margin-bottom: 20px;
            text-align: right;
        }

        .search-container input[type=text] {
            padding: 8px;
            margin-top: 8px;
            font-size: 17px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-container button {
            padding: 8px 12px;
            margin-top: 8px;
            background: #1fa7c2; /* Teal */
            font-size: 17px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: white;
        }

        .search-container button:hover {
            background: #0f828b; /* Darker teal on hover */
        }

        /* Image styling */
        .stock-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Include header -->
    <header>
        <div class="logo">
            <img src="images/s1.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="navigation.html"><i class="fas fa-home"></i> HOME</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn"><i class="fas fa-bars"></i> DASHBOARD</a>
                    <div class="dropdown-content">
                        <a href="http://localhost/stock_table/index.html">STOCK MAINTENANCE FORM</a>
                        <a href="http://localhost/stock_table/view.php">VIEW STOCKS</a>
                        <a href="http://localhost/stock_table/bill.html">GENERATE BILL</a>
                        <a href="http://localhost/stock_table/bardiagram.html">BAR DIAGRAM</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Stock Maintenance Records</h2>

        <!-- Search bar -->
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names..">
        </div>

        <!-- Table -->
        <table id="stockTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date Received</th>
                    <th>Expiry Date</th>
                    <th>Amount</th>
                    <th>Quantity</th>
                    <th>Image</th> <!-- New column for image -->
                </tr>
            </thead>
            <tbody>
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

                // Pagination variables
                $limit = 5; // Number of entries per page
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                // SQL query to fetch data with pagination
                $sql = "SELECT * FROM stock_table order by id desc LIMIT $start, $limit";

                // Execute SQL query
                $result = $conn->query($sql);

                // Check if there are any rows returned
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["date-received"]) . "</td>"; // Adjusted field name
                        echo "<td>" . htmlspecialchars($row["expiry-date"]) . "</td>"; // Adjusted field name
                        echo "<td>" . htmlspecialchars($row["amount"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                        echo "<td><img width='40px' src='SERVER/uploads/" . htmlspecialchars($row["image"] ) . "'/></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>0 results</td></tr>";
                }

                // Close connection
                $conn->close();
            ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php
                // Establishing database connection again for pagination
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Count total number of records
                $sql_count = "SELECT COUNT(*) AS total FROM stock_table";
                $result_count = $conn->query($sql_count);
                $row_count = $result_count->fetch_assoc();
                $total_pages = ceil($row_count['total'] / $limit);

                // Previous button
                if ($page > 1) {
                    echo "<a href='view.php?page=".($page - 1)."'>Previous</a>";
                }

                // Numbered page links
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a href='view.php?page=".$i."'";
                    if ($i == $page) {
                        echo " class='active'";
                    }
                    echo ">".$i."</a>";
                }

                // Next button
                if ($page < $total_pages) {
                    echo "<a href='view.php?page=".($page + 1)."'>Next</a>";
                }

                // Close connection
                $conn->close();
            ?>
        </div>
    </div>

    <script>
        // JavaScript function to filter table rows based on input
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("stockTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Index 1 for the name column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Example JavaScript code to handle row click and AJAX request
        $(document).ready(function() {
            // Attach click event handler to table rows
            $('#stockTable tbody').on('click', 'tr', function() {
                var id = $(this).find('td:first').text(); // Assuming the first column contains the ID

                // AJAX request to fetch data from new_billfetch.php
                $.ajax({
                    url: 'bill_fetch.php',
                    type: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function(data) {
                        // Handle success, for example, show data in a modal or update UI
                        console.log(data); // Output fetched data to console (for testing)
                        // Example: Show data in an alert (replace with your actual UI update code)
                        alert('Data fetched successfully: ' + JSON.stringify(data));
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('AJAX Error: ' + status + ' - ' + error);
                        alert('Error fetching data. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
