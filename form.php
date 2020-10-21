<?php

function form(){


return $form_content="
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

function form2(){

return $form_content="<form action='' method='POST'>
        <p>Введите ваш логин:</p>
        <input type='text' name='login'>
        <p>Введите ваш пароль:</p>
        <input type='password' name='password'><br><br>
        <input type='submit' name='submit' value='Отправить'>
    </form>";
}

function form3(){

  return $form_content="
<form action='' method='POST'>
    <p>Введите вваше обращение:</p>
    <textarea name='text' placeholder='Кот, Барсик, белый, 2,5 года'></textarea>
    <p>Введите номер вашего телефона:</p>
    <input type='tel' name='contacts'><br><br>
    <input type='submit' name='submit' value='Отправить'>
</form> ";
}
function form4(){
if(isset($_SESSION['phone_numb'])){
    $phone_numb = $_SESSION['phone_numb'];
}else{
    $phone_numb = '';
}
   return $form_content="
<form action='' method='POST'>
    <p>Введите вваше обращение:</p>
    <textarea name='text' placeholder='Найден Кот в раёне набережной, белый, примерный возраст 2,5 года'></textarea>
    <p>Введите ваш номер тедефона:</p>
    <input type='tel' name='contacts' value=\"$phone_numb\"><br><br>
    <input type='submit' name='submit' value='Отправить'>
</form> ";
}