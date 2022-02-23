<?php
function checkAuth(string $login, string $password): bool 
{
    $users = require __DIR__ . '/usersDB.php';

    foreach ($users as $user) {
        if ($user['login'] === $login 
            && $user['password'] === $password
        ) {
            return true;
        }
    }

    return false;
}

function out () {     
    SetCookie("login", ""); //удаляются cookie с логином    
    
    SetCookie("password", ""); //удаляются cookie с паролем     
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/WEB-Aitu/admin/login.php'); //перенаправление на главную страницу сайта 
}

function bd_conn(): mysqli{
    $hostname = "abdigavu.beget.tech";
    $username = "abdigavu_admin";
    $password = "bastyqtynBalasy258@";
    $dbname = "abdigavu_admin";
    $conn = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection failed." .mysqli_connect_error());
    return $conn;
}

function checker(string $login, string $pass): bool
{
    $conn = bd_conn();
    $request = "SELECT * from authorization WHERE log = \"$login\" AND pass = \"$pass\"";
    $query = mysqli_query($conn, $request);
    if(mysqli_num_rows($query) !== 0){
        return true;
    } else {
        return false;
    }
    
}

function getfromStatus($status){
    $conn = bd_conn();
    $request = "SELECT user_id FROM applications WHERE status = '$status'";
    // Execute it, or return the error message if there's a problem.
    $query = mysqli_query($conn, $request) or die(mysql_error());
    return json_encode(mysqli_fetch_all($query));
}

function makeReadyTable($status){
    $conn = bd_conn();
    $readyiin = json_decode(getfromStatus($status));
    $students = [];
    $counter = 0;
    foreach($readyiin as $iins){
        $iin = $iins[0];
        $request = "SELECT username, barcode, birthday, user_group FROM students WHERE user_id = '$iin'";
        $query = mysqli_query($conn, $request) or die(mysql_error());
        $data = json_decode(json_encode(mysqli_fetch_all($query)));
        $students[$counter][0] = $iin;
        $students[$counter][1] = $data[0][0];
        $students[$counter][2] = $data[0][1];
        $students[$counter][3] = $data[0][2];
        $students[$counter][4] = $data[0][3];
        if($status == 3){
            $new_req = "SELECT identificator FROM applications WHERE user_id = '$iin'";
            $query = mysqli_query($conn, $new_req) or die(mysql_error());
            $data = json_decode(json_encode(mysqli_fetch_all($query)));
            $URL = "http://45.90.34.249/".$data[0][0].".pdf";
            $students[$counter][5] = $URL;
        }
        $counter++;
    }
    return $students;
}

function getUserLogin(): ?string
{
    $loginFromCookie = $_COOKIE['login'] ?? '';
    $passwordFromCookie = $_COOKIE['password'] ?? '';

    if (checker($loginFromCookie, $passwordFromCookie)) {
        return $loginFromCookie;
    }

    return null;
}