<?php
$user_id = $_POST["post_userID"];
$enroll_Type = $_POST["post_enrollID"];


$hostname = "localhost";
$username = "abdigavu_admin";
$password = "bastyqtynBalasy258@";
$dbname = "abdigavu_admin";

$conn = mysqli_connect($hostname, $username, $password, $dbname)
or die("Database connection failed." .mysqli_connect_error());

$request = "SELECT `insertDate` FROM `applications` WHERE `user_id` = '$user_id' and `enrollType` = '$enroll_Type'";

$query = mysqli_query($conn, $request);

if(mysqli_num_rows($query) === 0){
    echo true;
} else {
    date_default_timezone_set('Asia/Almaty');
    $date = date('Y-m-d');
    while($row = $query -> fetch_assoc()){
        $datetime1 = date_create($date);
        $datetime2 = date_create($row["insertDate"]);
        $interval = date_diff($datetime1, $datetime2);

        if($interval >= 7){
            echo true;
        } else {
            echo false;
        }
    }
}

mysqli_close($conn);
