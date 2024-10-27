<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Sanchanala 2k20</title>
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
    </head>
    <body>
    <?php require 'utils/adminHeader.php'; ?>
    
    <form method="POST">
        <div class="w3-container"> 
            <div class="content"><!--body content holder-->
                <div class="container">
                    <div class="col-md-6 col-md-offset-3">

                        <label>Company Name:</label><br>
                        <input type="text" name="companyName" required class="form-control"><br><br>

                        <label>Sponsor Name:</label><br>
                        <input type="text" name="sponsorName" required class="form-control"><br><br>

                        <label>Referred By:</label><br>
                        <input type="text" name="referredBy" required class="form-control"><br><br>

                        <label>Amount:</label><br>
                        <input type="number" name="amount" required class="form-control"><br><br>

                        <button type="submit" class="btn btn-default pull-right">Submit <span class="glyphicon glyphicon-send"></span></button>

                        <a class="btn btn-default navbar-btn" href="adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>

                        <!-- Wide button for View Sponsor List -->
                        <button type="button" class="btn btn-primary btn-block" style="margin-top: 20px;" onclick="window.location.href='sponsorList.php'">View Sponsor List</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <?php require 'utils/footer.php'; ?>
    </body>
</html>

<?php
// Include your database connection file here
require 'classes/db1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyName = $_POST['companyName'];
    $sponsorName = $_POST['sponsorName'];
    $referredBy = $_POST['referredBy'];
    $amount = $_POST['amount'];

    // SQL query to insert sponsor data into the sponsors table
    $sql = "INSERT INTO sponsors (company_name, sponsor_name, referred_by, amount) 
            VALUES ('$companyName', '$sponsorName', '$referredBy', '$amount')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Payment Successful!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
