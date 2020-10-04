<?php

include  'include.php';
$content='';
$form_content="
<form action='' method='POST'>
    <p>Введите ваше Имя и Фамилию:</p>
    <input type='text' name='name'>
    <p>Введите ваш email:</p>
    <input type='email' name='email'>
    <p>Введите номер вашего телефона:</p>
    <input type='tel' name='phone'>
    <p>Введите желаемый логин:</p>
    <input type='text' name='login'>
    <p>Введите желаемый пароль:</p>
    <input type='password' name='password'><br><br>
    <input type='submit' name='submit' value='Отправить'> 
</form>";

function registration($link){

    if(isset($_POST['name'])and isset($_POST['email']) and isset($_POST['phone'])
    and isset($_POST['login'])and isset($_POST['password'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $login =$_POST['login'];
        $password =$_POST['password'];

        $query="INSERT INTO users (name, email, phone_numb, login, password, access)
         VALUE ('$name', '$email', '$phone', '$login', '$password', '1')";
        mysqli_query($link, $query) or die(mysqli_error($link));

    }

}  

registration($link);
include 'layout.php';