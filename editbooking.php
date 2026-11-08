<?php
ob_start(); // start output buffering untuk elak header error
include("header.template.php");
include("dbconnect.php");

// Semak BookingID dihantar
if(isset($_GET['BookingID'])){
    $bookingID = $_GET['BookingID'];

    // Dapatkan info booking
    $sql = "SELECT * FROM booking WHERE BookingID='$bookingID'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) > 0){
        $booking = mysqli_fetch_assoc($res);
    } else {
        echo "<div class='alert alert-warning' style='width:80%; margin:20px auto;'>Booking not found.</div>";
        include("footer.template.php");
        exit();
    }
} else {
    echo "<div class='alert alert-warning' style='width:80%; margin:20px auto;'>No Booking ID provided.</div>";
    include("footer.template.php");
    exit();
}

// Proses update bila submit
if(isset($_POST['update'])){
    $homestayID = $_POST['homestayID'];
    $checkin    = $_POST['checkin'];
    $checkout   = $_POST['checkout'];

    // Dapatkan harga homestay
    $priceQ = mysqli_query($conn, "SELECT PricePerNight FROM homestay WHERE HomestayID='$homestayID'");
    $priceRow = mysqli_fetch_assoc($priceQ);

    $days = (strtotime($checkout) - strtotime($checkin)) / (60*60*24);
    $totalPrice = $days * $priceRow['PricePerNight'];

    // Update booking
    $sqlUpdate = "UPDATE booking 
                  SET HomestayID='$homestayID', CheckIn='$checkin', CheckOut='$checkout', TotalPrice='$totalPrice'
                  WHERE BookingID='$bookingID'";

    if(mysqli_query($conn, $sqlUpdate)){
        // redirect terus ke my booking tanpa error
        header("Location: customerbook.php?message=Booking+has+been+updated.");
        exit();
    } else {
        echo "<div class='alert alert-danger' style='width:80%; margin:20px auto;'>Error updating booking: ". mysqli_error($conn)."</div>";
    }
}
?>

<h2 style="text-align:center; margin-top:20px;">Edit Booking</h2>

<div style="width:500px; margin:30px auto; border:1px solid #ccc; padding:25px; border-radius:8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); background-color:#f9f9f9;">

<form method="POST">

    <label>Choose Homestay:</label><br>
    <select name="homestayID" class="form-control" required>
        <option value="">Select Homestay</option>
        <?php
        $homes = mysqli_query($conn, "SELECT HomestayID, HomestayName FROM homestay");
        while($h = mysqli_fetch_assoc($homes)){
            $selected = ($h['HomestayID'] == $booking['HomestayID']) ? "selected" : "";
            echo "<option value='{$h['HomestayID']}' $selected>{$h['HomestayName']}</option>";
        }
        ?>
    </select>
    <br>

    <label>Check In:</label><br>
    <input type="date" name="checkin" class="form-control" value="<?php echo $booking['CheckIn']; ?>" required><br>

    <label>Check Out:</label><br>
    <input type="date" name="checkout" class="form-control" value="<?php echo $booking['CheckOut']; ?>" required><br>

    <div style="text-align:center; margin-top:15px;">
        <button type="submit" name="update" class="btn btn-primary">Update Booking</button>
        <a href="customerbook.php" class="btn btn-warning">Back</a>
    </div>

</form>
</div>

<?php
include("footer.template.php");
ob_end_flush(); // flush output buffer
?>
