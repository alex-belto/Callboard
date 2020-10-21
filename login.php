<?php

include 'include.php';
include 'form.php';
$content='';



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

            $_SESSION['message'] = 'Авторизация успешна';
            header('location: index.php'); die();
            
        }else{
            $_SESSION['message'] = 'Введенные данные для авторизации не верны!';
        }
    }else{
        $_SESSION['message'] = 'Введенные данные для авторизации не верны!';
    }
    
}

include 'layout.php';

