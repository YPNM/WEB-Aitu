<?php
function checkAuth(string $login, string $password): bool 
{
    //$users = require __DIR__ . '/usersDB.php';
    $db = pg_connect('host=localhost dbname=WEB user=postgres password=Nastroika5!');
    $query = "SELECT login FROM log_pass";
    $result = pg_query($query);
    foreach ($result as $user) {
        if ($user === $login)
        {
            $query = "SELECT pass FROM log_pass where login = '" + $user + "'";
            $result = pg_query($query);
            if($result === $password)
            {
                return true;
            }
        }
    }

    return false;
}

function info(): void
{
    phpinfo();
}

function bdusers(): string
{
    include()
    $db = pg_connect('host=localhost dbname=WEB user=postgres password=Nastroika5!');
    $query = "SELECT login FROM log_pass";
    $result = pg_query($query);
    return $result;
}

function dbConnect(): bool
{
    $db = pg_connect('host=localhost dbname=WEB user=postgres password=Nastroika5!');
    $query = "SELECT login, pass FROM log_pass";
    $result = pg_query($query);
}

function getUserLogin(): ?string
{
    $loginFromCookie = $_COOKIE['login'] ?? '';
    $passwordFromCookie = $_COOKIE['password'] ?? '';

    if (checkAuth($loginFromCookie, $passwordFromCookie)) {
        return $loginFromCookie;
    }

    return null;
}

function pr ($val){
 $bt   = debug_backtrace();
 $file = file($bt[0]['file']);
 $src  = $file[$bt[0]['line']-1];
 $pat = '#(.*)'.__FUNCTION__.' *?\( *?(.*) *?\)(.*)#i';
 $var  = preg_replace ($pat, '$2', $src);
 echo '<script>console.log("'.trim($var).'='. 
  addslashes(json_encode($val,JSON_UNESCAPED_UNICODE)) .'")</script>'."\n";
}
?>