<?php
//using MySQLi
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'homestay booking';

//create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//check connection (selection if else)
if(!$conn) {
    //terminate system if not connected
    die("Connection Failed: ". mysqli_connect_error());
}
else {
    echo "DB Connected! <br>";
}
