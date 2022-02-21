<?php

$identificator = $_POST["post_identificator"];
$user_id = $_POST["post_userID"];
$enroll_id = $_POST["post_enrollID"];
$status = $_POST["post_status"];

//$identificator = "test";
//$user_id = "123456789123";
//$enroll_id = "1";
//$status = "1";

date_default_timezone_set('Asia/Almaty');
$date = date('Y-m-d');


$hostname = "localhost";
$username = "abdigavu_admin";
$password = "bastyqtynBalasy258@";
$dbname = "abdigavu_admin";

$conn = mysqli_connect($hostname, $username, $password, $dbname)
or die("Database connection failed." . mysqli_connect_error());
$request = "";

if($enroll_id === "2"){
    $city_name = $_POST["post_city"];
    $draftboard = $_POST["post_draftBoard"];
    $request = "INSERT INTO `applications` (`identificator`, `user_id`, `city_name`, `udo_name`, `enrollType`, `status`, `insertDate`) VALUES ('$identificator', '$user_id', '$city_name', '$draftboard', '$enroll_id', '$status', '$date');";
} else {
    $request = "INSERT INTO `applications` (`identificator`, `user_id`, `enrollType`, `status`, `insertDate`) VALUES ('$identificator', '$user_id', '$enroll_id', '$status', '$date');";
}

$correctIDorNot = "SELECT `username`, `birthday`, `user_group` FROM `students` WHERE `user_id` = '$user_id'";
$compareDate = "SELECT insertDate FROM applications WHERE user_id = $user_id and enrollType = $enroll_id";

$correctQuery = mysqli_query($conn, $correctIDorNot);

if (mysqli_num_rows($correctQuery) !== 0) {
    $compareDateQuery = mysqli_query($conn, $compareDate);
    $interval = "";
    while($row = $compareDateQuery -> fetch_assoc()){
        $datetime1 = strtotime($date);
        $datetime2 = strtotime($row["insertDate"]);
        $interval = ($datetime1 - $datetime2)/60/60/24;
    }
    if(mysqli_num_rows($compareDateQuery) === 0 || $interval >= 7){
        $addEnroll = mysqli_query($conn, $request);
        if($addEnroll === TRUE){
            $xml = file_get_contents("http://45.90.34.249:8000/sendenroll?id=$identificator");
            echo 4;
        } else {
            echo 3;
        }
    } else {
        echo 2;
    }
}
else
{
    echo 1;
}

mysqli_close($conn);