<?php
$user_id = $_POST["post_userID"];

$hostname = "localhost";
$username = "abdigavu_admin";
$password = "bastyqtynBalasy258@";
$dbname = "abdigavu_admin";

$conn = mysqli_connect($hostname, $username, $password, $dbname)
or die("Database connection failed." .mysqli_connect_error());

$request = "SELECT `username`, `birthday`, `user_group` FROM `students` WHERE `user_id` = '$user_id'";

$query = mysqli_query($conn, $request);

if(mysqli_num_rows($query) !== 0){
    echo json_encode(mysqli_fetch_assoc($query));
} else {
    echo false;
}

mysqli_close($conn);