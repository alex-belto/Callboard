<?php
include 'include.php';
include 'form.php';
include 'profile.php';
$content='';
$form_content= form3();

function addNote($link){
    if(isset($_POST['text']) and isset($_POST['contacts'])){
       $text= $_POST['text'];
       $contacts= $_POST['contacts'];
       $id= $_SESSION['id'];

        $query="INSERT INTO advert (text, user_id, contacts, issue) VALUES ('$text', '$id', '$contacts', '1')";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись успешно добавлена!';
    }
}

function getList($link){

    if(isset($_GET['page'])){
        $page= $_GET['page'];
    }else{
          $page=1;
    }

    $notesOnPage = 1;
    $referencePoint= ($page -1) * $notesOnPage;

    $query="SELECT text, contacts, name, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id WHERE issue='1' LIMIT $referencePoint, $notesOnPage";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $content = '';
    for($arr=[]; $step = mysqli_fetch_assoc($result); $arr[]=$step);

    foreach($arr as $value){
        $text = $value['text'];
        $name = $value['name'];
        $contacts= $value['contacts'];
        $email = $value['email'];
        if(!empty($contacts)){
            $phone_numb = '';
        }else{
            $phone_numb = $value['phone_numb'];
        }
        
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

    $query="SELECT COUNT(*) as count FROM advert WHERE issue='1' ";
    $count=mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
    $numbsOfPage= ceil($count/$notesOnPage);

    if($page != 1){
        $previous = $page-1;
        $content.="<a href=\"?page=$previous\"><<<</a>";
    }

    for($i=1; $i <= $numbsOfPage; $i++){
        $content.="<a href=\"?page=$i\">$i</a>";
    }

    if($page < $numbsOfPage){
        $next = $page+1;
        $content.="<a href=\"?page=$next\">>>></a>";
    }


    return $content;
}

addNote($link);

$content = getList($link);


include 'layout.php';