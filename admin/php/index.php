<?php
    include("class.php");
?>
<!doctype html>
<html lang="ru">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name=viewport content="width=device-width, initial-scale=1"> 

<link rel="stylesheet" href="style.css" type="text/css" media="screen">

<script src="jquery-3.2.1.min.js"></script>
<script src="history.js"></script>
<script src="document.js"></script>

<title><?php echo $data->title(); ?></title>
</head>
<body>

<div id="footer-l">
    <div id="page-l">
    <div id="logo">logo</div>
    <nav><ul class="nav"><?php echo $data->menu(); ?></ul></nav>
    </div>
</div>

<div id="footer-r">
    <div class="content"><?php echo($data->content($data->state(),$data->title())); ?></div>
</div>

</body>
</html>