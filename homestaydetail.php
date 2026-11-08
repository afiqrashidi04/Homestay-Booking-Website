<?php

include("header.template.php");

?>

<?php
include "dbconnect.php";

// Pastikan ID wujud sebelum query
$id = isset($_GET['id']) ? $_GET['id'] : '';

?>

<h2>Search Homestay</h2>

<?php
if($id != '') {

    // Query untuk satu homestay
    $sql = "SELECT * FROM homestay WHERE HomestayID = '$id'";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>

        <!-- Table untuk detail -->
        <table class="table table-striped">
            <tr>
                <th>Homestay Name</th>
                <th>Price Per Night</th>
                <th>Maximum Customer</th>
                <th>Description</th>
            </tr>
            <tr>
                <td><?php echo $row['HomestayName']; ?></td>
                <td>RM <?php echo $row['PricePerNight']; ?></td>
                <td><?php echo $row['MaxCustomer']; ?></td>
                <td><?php echo $row['Description']; ?></td>
            </tr>
        </table>

        <?php
    } else {
        echo "<p>No homestay found.</p>";
    }

} else {
    echo "<p>No ID received.</p>";
}
?>

<a href="searchform.php" class="btn btn-secondary">Back</a>
<a href="bookhomestay.php" class="btn btn-success">Book Now</a>

<?php

include("footer.template.php");

?>