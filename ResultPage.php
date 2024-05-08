<?php
header("Cache-Control: private, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat,26 Jul 1997 05:00:00 GMT");

// CONNECTING TO THE DATABASE
$servername = "mysql";
$username = "Rayan"; 
$password = "Rayan007@"; 
$dbname = "capstonebank"; 

$conn = new mysqli($servername, $username, $password, $dbname); 
// IF CONNECTION IS NOT SUCCESSFUL
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 
?>

<!-- HTML CODE STARTS -->
<!DOCTYPE html>
<html>
<head> 
    <title>Transaction Page</title>
    <style>
    body {
        padding-top: 60px;
        font-size: 25px;
        background: #f5fce3;
        background: -webkit-linear-gradient(to right, #f5fce3, #e1e6d6 );
        background: linear-gradient(to right, #f5fce3, #e1e6d6);
    }
    .center {
        background: #91c1c9;
        background: -webkit-linear-gradient(to bottom, #91c1c9, #5e9da8 );
        background: linear-gradient(to bottom, #91c1c9, #3a5f66);
        padding-top: 5px;
        display: block;
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto;
        width: 50%;    
    }
    .center2 {
        font-size: 15px;
        width: 100%;
    }
    table {
        margin: 0 auto; /* or margin: 0 auto 0 auto */
    }
    td, th {
        border: 1px solid #ddd;
        padding: 8px;
    }
    #Table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
    }
    #Table tr:nth-child(even) {
        background-color: #d2d3d4;
    }
    #Table tr:nth-child(odd) {
        background-color: #dee2e3;
    }
    #Table tr:hover {
        background-color: #b5d0eb;
    }
    #Table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #608fb3;
        color: white;
    }
    </style>    
    <script type="text/javascript">
    if(window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href); 
    }
    </script>
</head>

<!-- BODY -->
<body>
<!-- INCLUDING NAVBAR-->
<?php include('navbar.php'); ?>

<!-- PHP CODE STARTS HERE -->
<?php 
if(isset($_POST['form_submitted'])) {
    // These variables are collecting form data
    $PAYER_ID = $_POST['payerID'];
    $PAYEE_ID = $_POST['payeeID'];
    $AMOUNT = $_POST['amount'];

    // Sanitize inputs to prevent SQL injection
    $PAYER_ID = $conn->real_escape_string($PAYER_ID);
    $PAYEE_ID = $conn->real_escape_string($PAYEE_ID);
    $AMOUNT = $conn->real_escape_string($AMOUNT);

    if(empty($PAYER_ID) || empty($PAYER_ID) || empty($AMOUNT)) {
        // JavaScript code to notify user not to leave fields blank         
        echo "<script>alert('Empty Fields !!');</script>";
        echo "<script>window.location.href='Transfer.php';</script>";
        exit();
    }

    // CHECK IF AMOUNT IS GREATER THAN 0 OR NOT
    if($AMOUNT <= 0) {
        echo "<script>alert('Amount must be greater than zero !!');</script>";
        echo "<script>window.location.href='Transfer.php';</script>";
        exit();
    }

    if(!ctype_digit($AMOUNT) || !ctype_digit($PAYER_ID) || !ctype_digit($PAYEE_ID)) {
        echo "<script>alert('Entered value can only contain digits !!');</script>";
        echo "<script>window.location.href='Transfer.php';</script>";
        exit();
    }

    // CHECK IF PAYER ID EXISTS OR NOT
    $sqlcount = "SELECT COUNT(1) FROM accountdetails WHERE accID='$PAYER_ID'";
    $r =  $conn->query($sqlcount);
    $d = $r->fetch_row();
    if($d[0] < 1) {
        echo "<script>alert('Payer ID does not exist !!');</script>";
        echo "<script>window.location.href='Transfer.php';</script>";
        exit();
    }
    
    // CHECK IF PAYEE ID EXISTS OR NOT
    $sqlcount = "SELECT COUNT(1) FROM accountdetails WHERE accID='$PAYEE_ID'";
    $r =  $conn->query($sqlcount);
    $d = $r->fetch_row();
    if($d[0] < 1) {
        echo "<script>alert('Payee ID does not exist !!');</script>";
        echo "<script>window.location.href='Transfer.php';</script>";
        exit();
    }
    
    // CHECK IF PAYER HAS SUFFICIENT MONEY OR NOT
    $sql = "SELECT * FROM accountdetails WHERE accID='$PAYER_ID'";       
    if($result = $conn->query($sql)) {            
        $row1 = $result->fetch_array(); 
        if($row1['balance'] < $AMOUNT) {
            echo "<script>alert('Payer does not have required balance !!');</script>";
            echo "<script>window.location.href='Transfer.php';</script>";
            exit();
        }  
    }  

    // TRANSACTION FROM PAYER AND PAYEE BANK ACCOUNTS
    $sql = "SELECT * FROM accountdetails WHERE accID='$PAYER_ID'";       
    if($result = $conn->query($sql)) {            
        $row1 = $result->fetch_array(); 
        $PayerCurrentBalance = $row1['balance'] - $AMOUNT;
    }
    
    $sql2 = "SELECT * FROM accountdetails WHERE accID='$PAYEE_ID'";
    if($result = $conn->query($sql2)) {
        $row2 = $result->fetch_array();
        $PayeeCurrentBalance = $row2['balance'] + $AMOUNT;
    }

    // UPDATE DETAILS OF PAYER AND PAYEE
    $updatepayer = "UPDATE accountdetails SET balance='$PayerCurrentBalance' WHERE accID='$PAYER_ID'";
    $updatepayee = "UPDATE accountdetails SET balance='$PayeeCurrentBalance' WHERE accID='$PAYEE_ID'";

    if($conn->query($updatepayer) === TRUE && $conn->query($updatepayee) === TRUE) {
        // SETTING TIME ZONE
        date_default_timezone_set('Asia/Kolkata');           
        $date = date('Y-m-d H:i:s',time());

        // UPDATE HISTORY TABLE
        $InsertTransactTable = "INSERT INTO history (payer, payerAcc, payee, payeeAcc, amount, time) VALUES ('$row1[name]','$row1[accID]','$row2[name]','$row2[accID]','$AMOUNT','$date')";
        if($conn->query($InsertTransactTable) === TRUE) {
            echo "<div class='center'>";
            echo "<div class='center2'>";
            echo "<h1 style='text-align: center'>Transaction Successfully Completed</h1>";
            echo "<p style='text-align: center; font-size: 25px;'>Details of payer and payee are as follows</p>";
            echo "<table id='Table'>";
            echo "<tr><th></th><th>Account No</th><th>Name</th><th>Email</th></tr>";
            echo "<tr><td>Payer</td><td>".$row1['accID']."</td><td>".$row1['name']."</td><td>".$row1['email']."</td></tr>";
            echo "<tr><td>Payee</td><td>".$row2['accID']."</td><td>".$row2['name']."</td><td>".$row2['email']."</td></tr>";
            echo "</table>";
            echo "<br>";
            echo "<table id='Table' style='margin-bottom:15px;'>";
            echo "<tr><th></th><th>Old Balance</th><th>New Balance</th></tr>";
            echo "<tr><th>Payer</th><td style='color:black'>".$row1['balance']."</td><td style='color:black'>".$PayerCurrentBalance."</td></tr>";
            echo "<tr><th>Payee</th><td style='color:black'>".$row2['balance']."</td><td style='color:black'>".$PayeeCurrentBalance."</td></tr>";
            echo "</table>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<script>alert('Record of this transaction was not saved!');</script>";
        }
    } else {
        echo "<script>alert('Transaction was not successful!');</script>";
    }
} else {
    echo "<h1>All transactions are up to date</h1>";
}

// DATABASE CONNECTION CLOSES HERE
$conn->close();
?>
</body>
</html>
<!-- HTML CODE ENDS HERE -->