<?php
include("header.template.php");
include("dbconnect.php");
?>

<h2 style="text-align:center;">My Booking</h2>

<?php
// Papar mesej kalau ada
if(isset($_GET['message'])){
    echo "<div class='alert alert-success' style='width:80%; margin:20px auto; text-align:center;'>";
    echo htmlspecialchars($_GET['message']);
    echo "</div>";
}

// Jika customerID dihantar melalui URL (dari booking page), auto set
$selectedCustomerID = "";
if(isset($_GET['customerID'])){
    $selectedCustomerID = $_GET['customerID'];
}
?>

<div style="width:500px; margin:30px auto; border:1px solid #ccc; padding:20px; border-radius:8px;">

<form method="POST">

    Select Customer:<br>
    <select name="customerID" class="form-control">
        <option value="">Choose Customer</option>
        <?php
        $custList = mysqli_query($conn, "SELECT CustomerID, CustomerName FROM customer");
        while($c = mysqli_fetch_assoc($custList)) {
            $selected = ($c['CustomerID'] == $selectedCustomerID) ? "selected" : "";
            echo "<option value='{$c['CustomerID']}' $selected>{$c['CustomerName']}</option>";
        }
        ?>
    </select>
    <br>

    <center>
        <a href="bookhomestay.php" class="btn btn-warning">Back</a>
        <button type="submit" name="search" class="btn btn-primary">View Booking</button>
    </center>

</form>

</div>

<?php
// Jika POST search atau customerID sudah ada dari URL, paparkan table
if(isset($_POST['search']) || $selectedCustomerID != "") {

    // ambil customerID dari POST jika ada, else dari URL
    $customerID = isset($_POST['customerID']) ? $_POST['customerID'] : $selectedCustomerID;

    $sql = "SELECT b.BookingID, h.HomestayName, b.CheckIn, b.CheckOut, b.TotalPrice
            FROM booking b
            JOIN homestay h ON b.HomestayID = h.HomestayID
            WHERE b.CustomerID = '$customerID'";

    $result = mysqli_query($conn, $sql);

    echo "<div style='width:80%; margin:30px auto;'>";

    if(mysqli_num_rows($result) > 0) {

        echo "<table class='table table-striped'>";
        echo "<tr>
                <th>Booking ID</th>
                <th>Homestay</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Total Price (RM)</th>
                <th>Actions</th>
              </tr>";

        while($row = mysqli_fetch_assoc($result)) {

            echo "<tr>";
            echo "<td>".$row['BookingID']."</td>";
            echo "<td>".$row['HomestayName']."</td>";
            echo "<td>".$row['CheckIn']."</td>";
            echo "<td>".$row['CheckOut']."</td>";
            echo "<td>".$row['TotalPrice']."</td>";
            echo "<td>
                    <a href='editbooking.php?BookingID=".$row['BookingID']."' class='btn btn-sm btn-info'>Edit</a>
                    <a href='deletebooking.php?BookingID=".$row['BookingID']."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure to delete this booking?\");'>Delete</a>
                  </td>";
            echo "</tr>";

        }

        echo "</table>";

    } else {
        echo "<div class='alert alert-warning'>No booking found.</div>";
    }

    echo "</div>";
}
?>

<?php
include("footer.template.php");
?>
