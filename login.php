<?php

include 'include.php';
include 'form.php';
$content='';
if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
}


$form_content=form2();

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
            $_SESSION['name'] = $user['name'];
            $_SESSION['login']= $user['login'];
            $_SESSION['phone_numb']= $user['phone_numb'];
            $_SESSION['email']= $user['email'];

            echo 'Авторизация успешна';
            header('location: index.php');
            
        }else{
            echo 'Введенные данные для авторизации не верны!';
        }
    }else{
        echo 'Введенные данные для авторизации не верны!';
    }
    
}

include 'layout.php';

