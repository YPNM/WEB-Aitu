
<?php
require __DIR__ . '/php/authorization/auth.php';
if(!empty($_GET) && $_GET['action'] == "out")
{
    out(); 
}
else{
    $login = getUserLogin();

    if (!empty($_POST)) {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        if (checker($login, $password)) {
            setcookie('login', $login, 0, '/');
            setcookie('password', $password, 0, '/');
            header('Location: /index.php');
        } else {
            $error = 'Ошибка авторизации';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <?php if ($login === null): ?>
        <meta http-equiv="refresh" content="0;URL=/WEB-Aitu/admin/login.php" />
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/admin/css/student.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <header class="d-flex justify-content-center py-3">
                <ul class="nav nav-pills">
                    <?php if((!empty($_GET) && $_GET['action'] == "ready") || empty($_GET)): ?>
                    <li class="nav-item"><a href="/WEB-Aitu/admin/index.php/?action=ready" class="nav-link active" aria-current="page">Справки</a></li>
                    <li class="nav-item"><a href="?action=applic" class="nav-link">Заявки</a></li>
                    <li class="nav-item"><a href="?action=errors" class="nav-link">Ошибки</a></li>
                    <?php elseif(!empty($_GET) && $_GET['action'] == "applic"): ?>
                    <li class="nav-item"><a href="/WEB-Aitu/admin/index.php/?action=ready" class="nav-link" aria-current="page">Справки</a></li>
                    <li class="nav-item"><a href="?action=applic" class="nav-link active">Заявки</a></li>
                    <li class="nav-item"><a href="?action=errors" class="nav-link">Ошибки</a></li>
                    <?php elseif(!empty($_GET) && $_GET['action'] == "errors"): ?>
                    <li class="nav-item"><a href="/WEB-Aitu/admin/index.php/?action=ready" class="nav-link" aria-current="page">Справки</a></li>
                    <li class="nav-item"><a href="?action=applic" class="nav-link">Заявки</a></li>
                    <li class="nav-item"><a href="?action=errors" class="nav-link active">Ошибки</a></li>
                    <?php endif; ?>
                </ul>
                <a href="/WEB-Aitu/admin/index.php/?action=out"><button class="btn button">Выход</button></a>
            </header>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ИИН</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Баркод</th>
                    <th scope="col">Дата рождения</th>
                    <th scope="col">Группа</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Файл</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if((!empty($_GET) && $_GET['action'] == "ready") || empty($_GET)){
                        $arr = makeReadyTable(3);
                        for ($i = 0; $i <= count($arr)-1; $i++) {
                            echo "<tr>";
                            foreach($arr[$i] as $val) {
                                echo "<td>$val</td>"; 
                            }
                            echo "<td>Создан</td>";   
                            echo "</tr>";
                        }
                }
                else if((!empty($_GET) && $_GET['action'] == "applic")){
                        $arr = makeReadyTable(2);
                        for ($i = 0; $i <= count($arr)-1; $i++) {
                            echo "<tr>";
                            foreach($arr[$i] as $val) {
                                echo "<td>$val</td>"; 
                            }
                            echo "<td>В обработке</td>";   
                            echo "</tr>";
                        }
                }
                    else if((!empty($_GET) && $_GET['action'] == "errors")){
                        $arr = makeReadyTable(1);
                        for ($i = 0; $i <= count($arr)-1; $i++) {
                            echo "<tr>";
                            foreach($arr[$i] as $val) {
                                echo "<td>$val</td>"; 
                            }
                            echo "<td>Ошибка</td>";   
                            echo "</tr>";
                        }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<div class="main">

</div>
<script>
    const list = document.querySelectorAll('.nav-link');
    console.log(list)
    function activeLink(){
        list.forEach((item) => 
        item.classList.remove('active'));
        this.classList.add('active');
    }
    list.forEach((item) => 
    item.addEventListener('click',activeLink));
</script>


<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>