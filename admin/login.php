<?php
if (!empty($_POST)) {
    require __DIR__ . '/php/authorization/auth.php';

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkAuth($login, $password)) {
        setcookie('login', $login, 0, '/');
        setcookie('password', $password, 0, '/');
        header('Location: /WEB-Aitu/admin/index.php');
    } else {
        $error = 'Ошибка авторизации';
    }
}
?>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Авторизация</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="/WEB-Aitu/images/favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="/WEB-Aitu/admin/css/index.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
    </head>
    <body>
    <form action="/WEB-Aitu/admin/login.php" method="post">
        <div class="container d-flex vh-100">
            <div class="row mx-auto">
                <div class="col align-self-center p-4">
                    <div class="card text-dark mb-3 login_container">
                        <div class="card-header text-center" style="background: #ADD8E6;">
                            <a href="https://moodle.astanait.edu.kz"><img src="/WEB-Aitu/images/Astana%20IT%20University.png" width="150" height="70"></a>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-4">Авторизация</h5>
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control" name="login" id="login" placeholder="Admin">
                                <label for="login">Username</label>
                            </div>
                            <?php if (!isset($error)): ?>
                            <div class="form-floating mb-1">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                            <?php elseif (isset($error)): ?>
                                <div class="form-floating mb-1">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                                <p class="text-center mb-0" style="color: red"><?= $error ?></p>
                            <?php endif; ?>
                            <input type="submit" readonly class="btn button" value="Войти"></input>
                        </div>
                        <div class="card-footer text-center">
                            <span style="color: #657575">Техническая поддержка</span>
                            <a href="https://t.me/dabdigaziz"><button class="btn button">Telegram</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </form>
    </body>
</html>