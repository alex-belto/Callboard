<?php
include 'include.php';
include 'profile.php';
$formContent = '';

function jump($link){

    $blockTime = time()+3600*24;// сутки блокировки
    $freeTime = date("F j, Y, H:i", $blockTime);//дата снятия блокировки
    $id = $_SESSION['id'];
    
    $query = "SELECT * FROM users WHERE id = '$id'";// достаю существующий block_time
    $result = mysqli_fetch_assoc(mysqli_query($link, $query));
    $limit = $result['block_time'];//существующий block_time

    $query = "SELECT position, user_id,  id FROM advert WHERE position = (SELECT MAX(position) FROM advert )"; //Достаю максимальную позицию
    $result = mysqli_fetch_assoc(mysqli_query($link, $query));
    $topPosition = $result['position']; //текущее максимальное положение
    
    
    
    if(isset($_GET['position']) AND isset($_GET['ad_id'])){
        $positionUpdate = $_GET['position'];// id записи которая апдейтится
        $adId = $_GET['ad_id']; 
        if(time() > $limit){//наличие блокировки в данный момент
            $query = "SELECT id, position FROM advert WHERE position  BETWEEN '$positionUpdate' AND '$topPosition'";
            $result =  mysqli_query($link, $query) or die(mysqli_error($link));
            for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);
        foreach($arr as $value){
            $position = $value['position'];
            $forId = $value['id'];
            $downgradePosition =  $position - 1;
            $query = "UPDATE advert SET position = '$downgradePosition' WHERE id = '$forId'"; //понижаю все позиции на 1
            mysqli_query($link, $query) or die(mysqli_error($link));
        }
        
        $query="UPDATE advert SET position = '$topPosition' WHERE id = '$adId' ";// апдейтим нужную позицию
        mysqli_query($link, $query) or die(mysqli_error($link));
        
        $query="UPDATE users SET block_time = '$blockTime' WHERE id = '$id' "; // блок на аккаунт пользователя - 24 часа
        mysqli_query($link, $query) or die(mysqli_error($link));

        $_SESSION['message'] = "Ваша запись поднята в топ, следующая попытка возможна $freeTime";

        }else{
            $_SESSION['message'] = "Ваш лемит поднятий в топ на сегодня привышен, следующая попытка возможна $freeTime";
        }
    }
}

function getList($link){

    $userId = $_SESSION['id'];// id авторизированого пользователя
    $userRole = $_SESSION['role']; //роль пользователя
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }

    $notesOnPage = 4;
    $referencePoint = ($page - 1) * $notesOnPage;

    $query = "SELECT text, users.id, status,  name, position, advert.id as ad_id, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id ORDER BY position DESC LIMIT $referencePoint, $notesOnPage";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $content = '';
    for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);

    foreach($arr as $value){
        $text = $value['text'];
        $name = $value['name'];
        $phone_numb = $value['phone_numb'];
        $email = $value['email'];
        $adPosition = $value['position'];
        $adUserId = $value['id'];
        $adId = $value['ad_id'];
        $status = $value['status'];
        $count = 0;

        $query="SELECT COUNT(*) as count FROM comments WHERE ad_id = '$adId'";
        $count= mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
        
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
                </tr>";
            if($userRole == 'moderator' OR $userRole == 'admin'){
                $content.= "<tr>
                    <td><form method='GET'>";
                if($status == 'active'){  
                $content.="<button><a href=\"?banUserId=$adUserId\">Забанить </a></button>";
                }else{
                $content.= "<button><a href=\"?banUserId=$adUserId\">Разбанить </a></button>";
                }
                $content.= "<button><a href=\"?dellAdId=$adId\">Удалить запись</a></button> 
                    <button><a href=\"?editAdId=$adId\">Редактировать запись</a></button>
                    </form></td>
                </tr>"; //Функционал модера
            }
            if($userRole != 'guest'){
                $content.= "<tr>
                    <td><form method='GET'>
                    <button><a href=\"comment.php?ad_id=$adId&&count=$count\">Комментарии $count</a></button> 
                    </form></td>
                </tr>"; //Кнопака коммента
            }
            if($userId == $adUserId AND $userRole != 'guest'){
                
                $content.="<tr>
                                    <td><form method='GET'>
                                    <button><a href=\"index.php?position=$adPosition&ad_id=$adId\">Top up</a></button>
                                    </form></td>
                                </tr>"; //Кнопка поднятия позиции
            }
        $content.="</table><br>";
    }

    $query = "SELECT COUNT(*) as count FROM advert";//Подсчет кол-ва записей
    $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
    $numbsOfPage = ceil($count/$notesOnPage);//кол-во страниц, число записей делим на желаемое на страницу
    //$content.= $numbsOfPage;

    if($page != 1){
        $previous = $page-1;
        $content.= "<a href=\"?page=$previous\"><<<</a>";//стрелки
    }

    for($i = 1; $i <= $numbsOfPage; $i++){
        $content.="<a href=\"?page=$i\">$i</a>";
    }

    if($page < $numbsOfPage){
        $next = $page+1;
        $content.="<a href=\"?page=$next\">>>></a>";//стрелки
    }

    return $content;
}
if(isset($_SESSION['positionUpdate'])){
    echo $_SESSION['positionUpdate'] = $ad_id;
}

jump($link);
$content = getList($link);

include 'layout.php';