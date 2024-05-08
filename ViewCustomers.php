<?php
$servername = "mysql";
$username = "Rayan";
$password = "Rayan007@";
$dbname = "capstonebank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all customer details
$sql = "SELECT * FROM accountdetails";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>    
    <!-- CSS style sheet -->
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding-top: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
<!-- Navbar -->
<?php include('navbar.php'); ?>
<div class="container">
    <h2>Customer Details</h2>
    <table>
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Account No.</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Balance</th>
                <th>Passwords</th> 
            </tr>
        </thead>                     
        <?php
        // Check if $result is set and not null
        if (isset($result) && $result->num_rows > 0) {
            // Fetching and displaying customer details
            while($row = $result->fetch_assoc()) { 
        ?> 
        <tr>
            <td><?php echo $row['sno']; ?></td>
            <td><?php echo $row['accID']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['balance']; ?></td>
            <td><?php echo $row['passwords']; ?></td>
        </tr>
        <?php
            }
        } else {
            // No records found message
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        ?> 
    </table>
</div>
</body>
</html>
