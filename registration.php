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
    <input type='tel' name='phone'><br><br>
    <input type='submit' name='submit' value='Отправить'> 
</form>";

function registration($link){

    if(isset($_POST['name'])and isset($_POST['email']) and isset($_POST['phone'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];

        $query="INSERT INTO users (name, email, phone_numb, access) VALUE ('$name', '$email', '$phone', '1')";
        mysqli_query($link, $query) or die(mysqli_error($link));

    }

}  

registration($link);
include 'layout.php';