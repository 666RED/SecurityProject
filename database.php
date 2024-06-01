<?php
$host = "localhost";
$database_name = "security_project_db";
$username = "root";
$password = "";


$conn = mysqli_connect($host, $username, $password, $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
