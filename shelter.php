<?php
include 'include.php';
include 'form.php';
$content='';
$access ='0';
$form_content= form3();

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