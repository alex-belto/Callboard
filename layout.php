<!DOCTYPE html>
<html>
    <head>
        <title>Callboard</title>
        <meta charset = "utf-8">
        <link rel = "stylesheet" type = "text/css" href = "">
    </head>

    <body>
        <header>
            <ul>
                <li><a href = "index.php">Callboard</a></li>
                <li><a href = "shelter.php">Приютить</a></li>
                <li><a href = "lost.php">Потеряшки</a></li>
                <li><a href = "">Контакты</a></li>
                <?php
                if(!empty($_SESSION['auth'])){
                    ?><li><a href = "logout.php">Выйти из ситсемы</a></li>
                    <li><?= $_SESSION['name'] ?></li><?php
                }else{?>
                <li><a href = "login.php">Автоотзация</a></li>
                <li><a href = "registration.php">Регистрация</a></li><?php
                }
                ?>
            </ul>
        </header>
        <main>
            <?= $formContent ?><br>
            <?php if(isset($_SESSION['message'])) echo $_SESSION['message']; unset($_SESSION['message'])?><br>
            <?= $content ?>
        </main>
    </body>
</html>