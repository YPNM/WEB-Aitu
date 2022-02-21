<?php
$hostname = "localhost";
$username = "abdigavu_admin";
$password = "bastyqtynBalasy258@";
$dbname = "abdigavu_admin";

$conn = mysqli_connect($hostname, $username, $password, $dbname)
or die("Database connection failed." .mysqli_connect_error());
?>