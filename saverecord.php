<?php
if (isset($_POST['register'])) {

    include ("dbconnect.php");

    $customerID   = "C" . rand(0000,0050);
    $customerName = $_POST['customerName'];
    $phone        = $_POST['phone'];
    $email        = $_POST['email'];

    $check = mysqli_query($conn, 
        "SELECT * FROM customer WHERE Email='$email' OR Phone='$phone'");

    if(mysqli_num_rows($check) > 0){
        header("Location: RegistrationForm.php?message=Customer+already+exists.");
        exit();
    }

    $sql = "INSERT INTO customer (CustomerID, CustomerName, Phone, Email)
            VALUES ('$customerID','$customerName','$phone','$email')";

    $result = mysqli_query($conn, $sql);

    header("Location: searchform.php?message=The+record+has+been+saved.");
} else {
    header("Location: RegistrationForm.php?message=Please+key-in+first.");
}
?>