<?php
include "header.template.php";

if(isset($_GET['message'])){
    echo "<div class='alert alert-danger text-center'>";
    echo $_GET['message'] . "</div>";
}
?>

<div style="width:400px; margin:50px auto; border:1px solid #ccc; padding:20px; border-radius:8px;">
    <h3 style="text-align:center;">Registration Form</h3>

    <form action="saverecord.php" method="POST" name="register">

        Name:<br>
        <input type="text" name="customerName" placeholder="Enter your name" class="form-control" required><br>

        Phone Number:<br>
        <input type="text" name="phone" placeholder="Your phone number" class="form-control" required><br>

        Email:<br>
        <input type="email" name="email" placeholder="Email address" class="form-control" required><br>

        <center>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
            <a href="searchform.php" class="btn btn-success">Next</a>

        </center>

    </form>
</div>

<?php
include "footer.template.php";
?>
