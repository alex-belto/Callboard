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

       $query="SELECT position, user_id, id  FROM advert WHERE position = (SELECT MAX(position) FROM advert )"; //Достаю максимальную позицию
        $result = mysqli_fetch_assoc(mysqli_query($link, $query));
        $topPosition = $result['position'] + 1; //создаем следующий position
       
        $query="INSERT INTO advert (text, user_id, contacts, issue, position) VALUES ('$text', '$id','$contacts', '2', $topPosition)";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись успешно добавлена!';
        
    }
}



function jump($link){

    $block_time= time()+3600*24;// сутки блокировки
    $freeTime = date("F j, Y, H:i", $block_time);//дата снятия блокировки
    $id = $_SESSION['id'];
    
    $query= "SELECT * FROM users WHERE id = '$id'";// достаю существующий block_time
       $result = mysqli_fetch_assoc(mysqli_query($link, $query));
       $limit = $result['block_time'];//существующий block_time

    $query="SELECT position, user_id,  id FROM advert WHERE position = (SELECT MAX(position) FROM advert )"; //Достаю максимальную позицию
    $result = mysqli_fetch_assoc(mysqli_query($link, $query));
    $topPosition = $result['position']; //текущее максимальное положение
    $topId = $result['id']+ 1;//id максимальной позиции
    
    
    if(isset($_GET['position']) AND isset($_GET['ad_id'])){
        $positionUpdate= $_GET['position'];// id записи которая апдейтится
        $ad_id = $_GET['ad_id']; 
        // if(time() > $limit){//наличие блокировки в данный момент
            $query= "SELECT id, position FROM advert WHERE position  BETWEEN '$positionUpdate' AND '$topPosition'";
            $result =  mysqli_query($link, $query) or die(mysqli_error($link));
            for($arr=[]; $step= mysqli_fetch_assoc($result); $arr[] = $step);
        foreach($arr as $value){
            $position = $value['position'];
            $for_id = $value['id'];
            $downgradePosition =  $position - 1;
            $query = "UPDATE advert SET position = '$downgradePosition' WHERE id = '$for_id'"; //понижаю все позиции на 1
            mysqli_query($link, $query) or die(mysqli_error($link));
        }
        
        $query="UPDATE advert SET position = '$topPosition' WHERE id = '$ad_id' ";// апдейтим нужную позицию
        mysqli_query($link, $query) or die(mysqli_error($link));
        
        $query="UPDATE users SET block_time='$block_time' WHERE id = '$id' "; // блок на аккаунт пользователя - 24 часа
        mysqli_query($link, $query) or die(mysqli_error($link));

        $_SESSION['message']="Ваша запись поднята в топ, следующая попытка возможна .$freeTime";

        // }else{
        //     $_SESSION['message']= "Ваш лемит поднятий в топ на сегодня привышен, следующая попытка возможна .$freeTime";
        // }
    }
}

function getList($link){

    $user_id = $_SESSION['id'];// id авторизированого пользователя


    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page=1;
    }

    $notesOnPage =2;
    $referencePoint = ($page - 1) * $notesOnPage;

    $query="SELECT text, position, contacts, users.id , advert.id as ad_id, name, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id WHERE issue='2' ORDER BY position DESC LIMIT $referencePoint, $notesOnPage ";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $content='';
    for($arr=[]; $step = mysqli_fetch_assoc($result); $arr[]=$step);

    
    
    foreach($arr as $value){
        $text = $value['text'];
        $name = $value['name'];
        $contacts= $value['contacts'];
        $ad_id = $value['ad_id'];
        $ad_position = $value['position'];
        $ad_user_id= $value['id'];
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
                </tr>";
                if($user_id == $ad_user_id){
                
                    $content.="<tr>
                                    <td><form method='GET'>
                                    <button><a href=\"lost.php?position=$ad_position&ad_id=$ad_id\">Top up</a></button>
                                    </form></td>
                                </tr>";
                }
                
        $content.="</table><br>";
    }

    $query="SELECT COUNT(*) as count FROM advert WHERE issue = '2' ";
    $count=mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
    $numbsOfPage=ceil($count/$notesOnPage);

    if($page!=1){
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
jump($link);
addNote($link);
$content = getList($link);


include 'layout.php';