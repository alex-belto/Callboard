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
        $_SESSION['message'] = 'Запись успешно добавлена!';
        
    }
}

function jump($link){

    $block_time= time()+3600*24;// сутки блокировки
    $id = $_SESSION['id'];
    
    $query= "SELECT * FROM users WHERE id = '$id'";// достаю существующий block_time
       $result = mysqli_fetch_assoc(mysqli_query($link, $query));
       $limit = $result['block_time'];//существующий block_time

    $query="SELECT position, user_id, id  FROM advert WHERE position = (SELECT MAX(position) FROM advert )"; //Достаю максимальную позицию
    $result = mysqli_fetch_assoc(mysqli_query($link, $query));
    //$downgradeId= $result['id'];// id который будет понижаться
    $topPosition = $result['position']; //текущее максимальное положение
    $downgradePosition = ($topPosition - 1);
    
    if(isset($_SESSION['positionUpdate'])){
        $positionUpdate= $_SESSION['positionUpdate'];// id записи которая апдейтится 
        if(time() > $limit){
         
        $query = "UPDATE advert SET position = '$downgradePosition' WHERE position = '$topPosition'"; //понижаю все максимальные позиции
        mysqli_query($link, $query) or die(mysqli_error($link));
        $query="UPDATE advert SET position = '$topPosition' WHERE id = '$positionUpdate' ";// апдейтим нужную позицию
        mysqli_query($link, $query) or die(mysqli_error($link));
        
        $query="UPDATE users SET block_time='$block_time' WHERE id = '$id' "; // блок на аккаунт пользователя - 24 часа
        mysqli_query($link, $query) or die(mysqli_error($link));
        
        }else{
            $_SESSION['message']= 'Ваш лемит заявок на сегодня привышен';
        }
    }
}

function getList($link){

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page=1;
    }

    $notesOnPage =1;
    $referencePoint = ($page - 1) * $notesOnPage;

    $query="SELECT text, contacts, name, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id WHERE issue='2' LIMIT $referencePoint, $notesOnPage";
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
                
            </table><br>";
    }

    $query="SELECT COUNT(*) as count FROM advert WHERE issue = '2' ";
    $count=mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
    $numbsOfPage=ceil($count/$notesOnPage);

    if($page!=1){
        $previous = $page-1;
        $content.="<a href=\"?page=$previous\"><<<</a>";
    }

    for($i=1; $i <= $numbsOfPage; $i++){
        $content.="<a href=\"$i\">$i</a>";
    }

    if($page < $numbsOfPage){
        $next = $page+1;
        $content.="<a href=\"?page=$next\">>>></a>";
    }

    return $content;
}
jump($link);
addNote($link);
$content = getList($link);


include 'layout.php';