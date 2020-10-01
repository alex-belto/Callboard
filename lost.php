<?php

$form_content="
<form action='' method='POST'>
    <p>Введите вваше обращение:</p>
    <textarea name='text'></textarea>
    <p>Введите ваше Имя и Фамилию:</p>
    <input type='text' name='name' placeholder='Иванов Иван'>
    <p>Введите ваш email:</p>
    <input type='email' name='email'>
    <p>Введите номер вашего телефона:</p>
    <input type='tel' name='phone'>
    <input type='submit' name='submit' value='Отправить'>
</form> ";

include 'layout.php';