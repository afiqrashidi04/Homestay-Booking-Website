<?php

include("header.template.php");

if(isset($_GET['message'])){
    echo "<div class = 'alert alert-success'>";
    echo $_GET['message'] . "</div>";
}

?>

<div class = "float-right">
    <form method = "GET" action = "" class = "form-inline">
        <input type = "text" name = "keyword" placeholder = "Enter a homestay name" class = "form-control">
        <button type = "submit" class = "btn btn-primary"> Search </button>
    </form>
</div>

<?php

include "dbconnect.php";

$keyword = $_GET['keyword'];
$sql = "SELECT HomestayID, HomestayName, PricePerNight, MaxCustomer, Description FROM homestay WHERE HomestayName LIKE '%$keyword%'";

$result = mysqli_query($conn, $sql);

?>

<h2>Search Homestay</h2>
<table class="table table-striped">
    <tr>
        <th>Homestay Name</th>
        <th>Detail</th>
    </tr>

<?php

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['HomestayName'] . "</td>";
        echo "<td><a href='homestaydetail.php?id=" . $row['HomestayID'] . "' class='btn btn-info'>View Details</a></td>";
        echo "</tr>";
    }
}
else {
    echo "No results";
}

?>
</table>

<a href="RegistrationForm.php" class="btn btn-warning">Back</a>
<a href="bookhomestay.php" class="btn btn-success">Book Now</a>

<?php

include("footer.template.php");

?>