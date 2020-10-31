<?php
include 'include.php';
include 'profile.php';
include 'form.php';

function addComment($link){
    if(isset($_SESSION['id']) AND isset($_GET['ad_id']) AND isset($_POST['text'])){
    $userId = $_SESSION['id'];
    $adId = $_GET['ad_id'];
    $date = time();
    $count = $_GET['count'] + 1;
    $text = $_POST['text'];

    $query = "INSERT INTO comments (text, date, ad_id, user_id) VALUES ('$text', '$date', '$adId', '$userId')";
    mysqli_query($link, $query) or die(mysqli_error($link));
    $_SESSION['message'] = 'Коментарий успешно добавлен!';
    header ("location: comment.php?ad_id=$adId&&count=$count");
    }
}



function getAd($link){
    if(isset($_GET['ad_id'])){
    $adId = $_GET['ad_id'];
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }
    $userRole = $_SESSION['role'];

   $query = "SELECT text, name, phone_numb, email FROM users 
   RIGHT JOIN advert ON users.id = advert.user_id WHERE advert.id = '$adId'";
   $result = mysqli_fetch_assoc(mysqli_query($link, $query));

   $content = '';
   $text = $result['text'];
   $name = $result['name'];
   $phoneNumb = $result['phone_numb'];
   $email = $result['email'];
   

   $content .= "<p>Выбранная вами запись:</p>";
   $content .= "<table>
    <tr>
       <td>$text</td>
    </tr>
    <tr>
       <td>$name</td>
    </tr>
    <tr>
       <td>$phoneNumb</td>
    </tr>
    <tr>
       <td>$email</td>
    </tr>
    <tr>
        <td><br>Комментарии:</td>
    </tr>";

        if(isset($_GET['count']) AND $_GET['count'] > 0){

           
            $count = $_GET['count'];
            $notesOnPage = 2;
            $referencePoint = ($page - 1 ) * $notesOnPage;

            $query = "SELECT * FROM comments WHERE ad_id = '$adId' LIMIT $referencePoint, $notesOnPage";//вытаскиваю все коменты по этому посту
            $result = mysqli_query($link, $query) or die(mysqli_error($link));
            for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);

            foreach($arr as $value){
                $text = $value['text'];
                $date = date('Y-m-d H:i:s', $value['date']);
                $adUserId = $value['user_id'];

                $query = "SELECT  name, status, email FROM users WHERE id = '$adUserId'";
                $result = mysqli_fetch_assoc(mysqli_query($link, $query));
                $name = $result['name'];
                $email = $result['email']; 
                $status = $result['status'];
            $content .= "<tr>
            <td>------------------------------------</td>
            </tr>
            <tr>
                <td>$text</td>
            </tr>
            <tr>
                <td>$date</td>
            </tr>
            <tr>
                <td>$name</td>
            </tr>
            <tr>
                <td>$email</td>
            </tr>";

            }
            if($userRole == 'moderator' OR $userRole == 'admin'){
                $content.= "<tr>
                    <td><form method='GET'>";
                if($status == 'active'){  
                $content.="<button><a href=\"?ad_id=$adId&&count=$count&&banUserId=$adUserId\">Забанить </a></button>";
                }else{
                $content.= "<button><a href=\"?ad_id=$adId&&count=$count&&banUserId=$adUserId\">Разбанить </a></button>";
                }
                $content.= "<button><a href=\"?ad_id=$adId&&count=$count&&dellAdId=$adId\">Удалить запись</a></button> 
                    <button><a href=\"?ad_id=$adId&&count=$count&&editAdId=$adId\">Редактировать запись</a></button>
                    </form></td>
                </tr>"; //Функционал модера
            }
            $content.= "</table><br><br>";

    $query = "SELECT COUNT(*) as count FROM comments WHERE ad_id = '$adId'";//Подсчет кол-ва записей
    $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
    $numbsOfPage = ceil($count/$notesOnPage);//кол-во страниц, число записей делим на желаемое на страницу

    if($page != 1){
        $previous = $page-1;
        $content.= "<a href=\"?ad_id=$adId&&count=$count&&page=$previous\"><<<</a>";//стрелки
    }

    for($i = 1; $i <= $numbsOfPage; $i++){
        $content.="<a href=\"?ad_id=$adId&&count=$count&&page=$i\">$i</a>";
    }

    if($page < $numbsOfPage){
        $next = $page+1;
        $content.="<a href=\"?ad_id=$adId&&count=$count&&page=$next\">>>></a>";//стрелки
    }

    return $content;
        }else{
            $content.= "</table><br><br>";
            return $content;
        }
        
    }  

}

addComment($link);
$content = getAd($link);
$formContent = commentForm();




include 'layout.php';