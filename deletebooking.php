<?php
include("dbconnect.php");

// Semak ada BookingID dihantar
if(isset($_GET['BookingID'])) {
    $bookingID = $_GET['BookingID'];

    // Delete booking dari table
    $sql = "DELETE FROM booking WHERE BookingID='$bookingID'";
    if(mysqli_query($conn, $sql)){
        // Redirect ke customerbook.php dengan mesej
        header("Location: customerbook.php?message=Booking+has+been+deleted.");
        exit();
    } else {
        echo "Error deleting booking: " . mysqli_error($conn);
    }
} else {
    echo "Booking ID not provided.";
}
?>
