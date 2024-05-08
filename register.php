<?php
// Database connection
$servername = "mysql";
$username = "Rayan";
$password = "Rayan007@";
$dbname = "capstonebank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to securely hash passwords with 6-character encryption key
function hashPassword($password) {
    // Hash the password using SHA-256 encryption and return the first 32 characters
    return substr(hash('sha256', $password), 0, 8);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $accID = $_POST['accID'];
    $email = $_POST['email'];
    $balance = $_POST['balance'];
    $password = $_POST['passwords'];
    $encrypted_password = hashPassword($password);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO accountdetails (name, accID, email, balance, passwords) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisis", $name, $accID, $email, $balance, $encrypted_password);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        $stmt->close();
        $conn->close();
        // Redirect to success page or home page
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
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
        /* CSS styles here */
    </style>
</head>

<body>
<!-- Navbar -->
<?php include('navbar.php'); ?>
<div class="container">
    <h2 style="text-align: center">Customer Details</h2>
    <br>                   
    <table id="Table">
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
        if (isset($result) && $result !== null && $result->num_rows > 0) {
            // Fetching and displaying customer details
            while($row = $result->fetch_assoc()) { 
        ?> 
        <tr>
            <td><?php echo isset($row['sno']) ? $row['sno'] : ""; ?></td>
            <td><?php echo $row['accID']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['balance']; ?></td>
            <td><?php echo substr($row['passwords'], 0, 32); ?></td>
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
<footer style="text-align: center">
    <p>Designed and Coded by: Rayan, Mahesh and Priyanshu</p>
</footer>
</body>
</html>
