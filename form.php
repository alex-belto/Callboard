<?php

function registrationForm(){


return $formContent = "
    <form action='' method='POST'>
        <p>Введите ваше Имя и Фамилию:</p>
        <input type='text' name='name'>
        <p>Введите ваш email:</p>
        <input type='email' name='email'>
        <p>Введите номер вашего телефона:</p>
        <input type='tel' name='phone'>
        <p>Введите жедаемый логин:</p>
        <input type='text' name='login'>
        <p>Введите желаемый пароль</p>
        <input type='password' name='password'>
        <p>Подтвердите желаемый  пароль:</p>
        <input type='password' name='confirm'><br><br>
        <input type='submit' name='submit' value='Отправить'> 
    </form>";
}

function loginForm(){

return $formContent = "<form action='' method='POST'>
        <p>Введите ваш логин:</p>
        <input type='text' name='login'>
        <p>Введите ваш пароль:</p>
        <input type='password' name='password'><br><br>
        <input type='submit' name='submit' value='Отправить'>
    </form>";
}

function shelterForm(){
    if(isset($_SESSION['phone_numb'])){
        $phoneNumb = $_SESSION['phone_numb'];
    }else{
        $phoneNumb = '';
    }
  return $formContent = "
<form action='' method='POST'>
    <p>Введите вваше обращение:</p>
    <textarea name='text' placeholder='Кот, Барсик, белый, 2,5 года'></textarea>
    <p>Введите номер вашего телефона:</p>
    <input type='tel' name='contacts' value=\"$phoneNumb\"><br><br>
    <input type='submit' name='submit' value='Отправить'>
</form> ";
}
function lostForm(){
if(isset($_SESSION['phone_numb'])){
    $phoneNumb = $_SESSION['phone_numb'];
}else{
    $phoneNumb = '';
}
   return $formContent = "
<form action='' method='POST'>
    <p>Введите вваше обращение:</p>
    <textarea name='text' placeholder='Найден Кот в раёне набережной, белый, примерный возраст 2,5 года'></textarea>
    <p>Введите ваш номер телефона:</p>
    <input type='tel' name='contacts' value=\"$phoneNumb\"><br><br>
    <input type='submit' name='submit' value='Отправить'>
</form> ";
}

function commentForm(){
    
    return $formContent = "
    <form action='' method='POST'>
        <p>Введите ваш комментарий:</p>
        <textarea name='text' placeholder=''></textarea><br><br>
        
        <input type='submit' name='submit' value='Отправить'>
    </form>";
}
