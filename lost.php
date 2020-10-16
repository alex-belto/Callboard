<?php
include 'include.php';
include 'form.php';
include 'profile.php';
$content='';
$form_content= form4();

function addNote($link){
    if(isset($_POST['text']) and isset($_POST['contacts'])){
       $text= $_POST['text'];
       $contacts= $_POST['contacts'];
       $id = $_SESSION['id'];
       

        $query="INSERT INTO advert (text, user_id, contacts, issue) VALUES ('$text', '$id','$contacts', '2')";
        mysqli_query($link, $query) or die(mysqli_error($link));
    }
}

function getList($link){
    $query="SELECT text, contacts, name, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id WHERE issue='2' ";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $content='';
    for($arr=[]; $step = mysqli_fetch_assoc($result); $arr[]=$step);

    foreach($arr as $value){
        $text = $value['text'];
        $name = $value['name'];
        $contacts= $value['contacts'];
        if(!empty($contacts)){
            $phone_numb = '';
        }else{
            $phone_numb = $value['phone_numb'];
        }
        $email = $value['email'];

        $content.="
            <table>
                <tr>
                    <td>$text</td>
                </tr>
                <tr>
                    <td>$name</td>
                </tr>
                <tr>
                    <td>$contacts</td>
                </tr>
                <tr>
                    <td>$phone_numb</td>
                </tr>
                <tr>
                    <td>$email</td>
                </tr>
                
            </table><br><br>";
    }
    return $content;
}

addNote($link);
$content = getList($link);


include 'layout.php';