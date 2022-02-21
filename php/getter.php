<?php
$user_id = $_POST["post_userID"];
$enroll_id = $_POST["post_enrollID"];

//$user_id = "123456789123";
//$enroll_id = "3";

$hostname = "localhost";
$username = "abdigavu_admin";
$password = "bastyqtynBalasy258@";
$dbname = "abdigavu_admin";

$conn = mysqli_connect($hostname, $username, $password, $dbname)
or die("Database connection failed." .mysqli_connect_error());

$request = "SELECT identificator, status FROM applications WHERE user_id = $user_id and enrollType = $enroll_id";

$query = mysqli_query($conn, $request);

if(mysqli_num_rows($query) !== 0){
    echo json_encode(mysqli_fetch_all($query));
} else {
    echo false;
}

mysqli_close($conn);
