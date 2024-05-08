<?php
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
        background: linear-gradient(to right, #f5fce3,#e1e6d6 );
    }
    .transferMoney {
        color: white;
        background: #91c1c9;
        background: -webkit-linear-gradient(to bottom, #91c1c9, #5e9da8 );
        background: linear-gradient(to bottom, #91c1c9, #3a5f66);
        padding: 20px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    </style>   
    <script type="text/javascript">
    if(window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href); 
    }

    function validateForm() {
        var x = document.forms["myForm"]["payerID"].value;
        var y = document.forms["myForm"]["payeeID"].value;
        var z = document.forms["myForm"]["amount"].value;
        var regex = /^[0-9]+$/;

        if (x == "" || y == "" || z == "") {
            alert("Please fill in all fields.");
            return false;
        }

        if (!regex.test(x) || !regex.test(y) || !regex.test(z)) {
            alert("Please enter valid numeric input.");
            return false;
        }

        if (z <= 0) {
            alert("Amount must be greater than zero.");
            return false;
        }

        return true;
    }
    </script>
</head>
<!-- BODY-->
<body>
<!-- INCLUDING NAVBAR-->
<?php include('navbar.php'); ?>
<!-- Creating Form to collect information related to do transaction-->
<div class="transferMoney">
    <h1>Transfer Money</h1>
    <!-- Form's action attribute points to this page only-->
    <!-- Note: To redirect page to the same PHP write "php echo $_SERVER['PHP_SELF'];" in action attribute-->
    <form name="myForm" action="ResultPage.php" onsubmit="return validateForm()" method="post">
        <!-- To structurize form it is put in a table-->
        <table id="table1">
            <!-- ROW 1: PAYER ACCOUNT ID IS ASKED-->
            <tr>
                <td>Payer Account No</td>
                <td><input type="number" name="payerID" min="100" required></td>
            </tr>
            <!-- ROW 2: PAYEE ACCOUNT ID IS ASKED-->
            <tr>
                <td>Payee Account No</td>
                <td><input type="number" name="payeeID" min="100" required></td>
            </tr>
            <!-- ROW 3: AMOUNT TO BE TRANSFERRED IS ASKED-->
            <tr>
                <td>Amount (in Rupees)</td>
                <td><input type="number" name="amount" min="1" required></td>
            </tr>
            <!-- ROW 4: BUTTON TO ASK TO CONFIRM TRANSACTION-->
            <tr>
                <td><input type="hidden" name="form_submitted" value="1"></td>
                <td><input type="submit" value="PROCEED"></td>
            </tr>
        </table>
    </form>
</div>
<!-- FORM / TABLE ENDS HERE WITH DIV TAG-->
</body>
</html>
<!-- HTML CODE ENDS HERE-->
<!-- MADE BY RAYAN CHOWDHURY -->