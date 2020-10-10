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

if(isset($_POST['login'])){
    $login = $_POST['login'];

    $query="SELECT * FROM users WHERE login = '$login'";
    $user =mysqli_fetch_assoc(mysqli_query($link, $query));

    if(!empty($user)){
        $hash = $user['password'];
        $password = password_verify($_POST['password'], $hash);

        if($hash == $password){
            $_SESSION['auth']= true;
            $_SESSION['id']=$user['id'];
            header('location: index.php');
            echo 'Авторизация успешна';
            
        }else{
            echo 'Введенные данные для авторизации не верны!';
        }
    }else{
        echo 'Введенные данные для авторизации не верны!';
    }
    
}

include 'layout.php';

