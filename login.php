<?php

include 'include.php';
$content='';

$form_content="<form action='' method='POST'>
    <p>Введите ваш логин:</p>
    <input type='text' name='login'>
    <p>Введите ваш пароль:</p>
    <input type='password' name='password'><br><br>
    <input type='submit' name='submit' value='Отправить'>
</form>";

if(isset($_POST['login'], $_POST['password'])){
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query="SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    $result = mysqli_query($link, $query);
    
    $user = mysqli_fetch_assoc($result);
    //var_dump($user);
    if(!empty($user)){
        $_SESSION['auth']= true;
        $_SESSION['id']=$user['id'];
        header('location: index.php');
        echo 'Авторизация успешна';
    }else{
        echo 'Проверьте введенные вами данные';
    }
}

include 'layout.php';

