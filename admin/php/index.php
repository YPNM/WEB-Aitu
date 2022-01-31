<?php
<<<<<<< HEAD
require __DIR__ . '/authorization/auth.php';
=======
require __DIR__ . '\authorization\auth.php';
>>>>>>> 8b3653f6045deaada7d99a98aa9b65b3e609d094
$login = getUserLogin();
?>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
<?php if ($login === null): ?>
<a href="/login.php">Авторизуйтесь</a>
<?php else: ?>
Добро пожаловать, <?= $login ?>
<br>
<a href="/logout.php">Выйти</a>
<?php endif; ?>
</body>
</html>