<?php

include("header.template.php");
include ("dbconnect.php");

if (isset($_POST['book'])) {

    $customerID = $_POST['customerID'];
    $homestayID = $_POST['homestayID'];
    $checkin    = $_POST['checkin'];
    $checkout   = $_POST['checkout'];

    $bookingID   = "B" . rand(0000,0050);
    $bookingDate = date("Y-m-d");

    if($customerID != "") {
        $checkSQL = "SELECT * FROM booking 
                     WHERE HomestayID = '$homestayID'
                     AND (
                        ('$checkin' BETWEEN CheckIn AND CheckOut)
                        OR ('$checkout' BETWEEN CheckIn AND CheckOut)
                        OR (CheckIn BETWEEN '$checkin' AND '$checkout')
                     )";
        $checkResult = mysqli_query($conn, $checkSQL);

        if(mysqli_num_rows($checkResult) > 0){
            echo "<div class='alert alert-danger'>This homestay is NOT available for selected date.</div>";
        }
        else{

            // get price
            $priceQ = mysqli_query($conn,
                "SELECT PricePerNight FROM homestay WHERE HomestayID='$homestayID'");
            $priceRow = mysqli_fetch_assoc($priceQ);

            $days = (strtotime($checkout) - strtotime($checkin)) / (60*60*24);
            $totalPrice = $days * $priceRow['PricePerNight'];

            $sql = "INSERT INTO booking
            (BookingID, CustomerID, HomestayID, CheckIn, CheckOut, BookingDate, TotalPrice)
            VALUES
            ('$bookingID','$customerID','$homestayID','$checkin','$checkout','$bookingDate','$totalPrice')";

            mysqli_query($conn, $sql);

            echo "<script>window.location='customerbook.php?message=The+book+has+been+saved.';</script>";

        } // end else availability

    } else {
        echo "<div class='alert alert-danger'>Please select customer.</div>";
    }
}
?>

<h2 style="text-align:center;">Book Homestay</h2>

<div style="width:450px; margin:40px auto; border:1px solid #ccc; padding:25px; border-radius:8px;">

<form method="POST">

    Customer Name:<br>
    <select name="customerID" class="form-control">
        <option value="">Select Customer</option>
        <?php
        $custList = mysqli_query($conn, "SELECT CustomerID, CustomerName FROM customer");
        while($c = mysqli_fetch_assoc($custList)) {
            echo "<option value='{$c['CustomerID']}'>{$c['CustomerName']}</option>";
        }
        ?>
    </select>
    <br>

    Choose Homestay:<br>
    <select name="homestayID" class="form-control">
        <option value="">Select Homestay</option>
        <?php
        $homes = mysqli_query($conn, "SELECT HomestayID, HomestayName FROM homestay");
        while($h = mysqli_fetch_assoc($homes)) {
            echo "<option value='{$h['HomestayID']}'>{$h['HomestayName']}</option>";
        }
        ?>
    </select>
    <br>

    Check In:<br>
    <input type="date" name="checkin" class="form-control"><br>

    Check Out:<br>
    <input type="date" name="checkout" class="form-control"><br>

    <center>
        <a href="searchform.php" class="btn btn-warning">Back</a>
        <button type="submit" name="book" class="btn btn-primary">Book</button>
        <a href="customerbook.php" class="btn btn-success">Check</a>
    </center>

</form>
</div>

<?php
include("footer.template.php");
?>
