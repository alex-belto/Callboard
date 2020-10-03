<?php
include 'include.php';
$content='';
$access ='0';
$form_content="
<form action='' method='POST'>
    <p>Введите вваше обращение:</p>
    <textarea name='text' placeholder='Кот, Барсик, белый, 2,5 года'></textarea>
    <p>Введите ваше Имя и Фамилию:</p>
    <input type='text' name='name' placeholder='Иванов Иван'>
    <p>Введите ваш email:</p>
    <input type='email' name='email'>
    <p>Введите номер вашего телефона:</p>
    <input type='tel' name='phone'><br><br>
    <input type='submit' name='submit' value='Отправить'>
</form> ";

function addNote($link){
    if(isset($_POST['text']) and isset($_POST['name']) and isset($_POST['email']) and isset($_POST['phone'])){
       $text= $_POST['text'];
       $name= $_POST['name'];
       $email= $_POST['email'];
       $phone= $_POST['phone'];

        $query="INSERT INTO users (name, email, phone_numb, access) VALUES ('$name', '$email', '$phone', '1')";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $query="INSERT INTO advert (text, user_id, issue) VALUES ('$text', '1', '1')";
        mysqli_query($link, $query) or die(mysqli_error($link));
    }
}

function getList($link){
    $query="SELECT text, name, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id WHERE issue='1' ";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    
    for($arr=[]; $step = mysqli_fetch_assoc($result); $arr[]=$step);

    foreach($arr as $value){
        $text = $value['text'];
        $name = $value['name'];
        $phone_numb = $value['phone_numb'];
        $email = $value['email'];
        $content='';
        $content.="
            <table>
                <tr>
                    <td>$text</td>
                </tr>
                <tr>
                    <td>$name</td>
                </tr>
                <tr>
                    <td>$phone_numb</td>
                </tr>
                <tr>
                    <td>$email</td>
                </tr>
                
            </table>";
    }
    return $content;
}

$content = getList($link);

addNote($link);

include 'layout.php';