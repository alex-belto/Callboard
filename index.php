<?php
include 'include.php';
include 'profile.php';
$form_content='';


function getList($link){

    $user_id = $_SESSION['id'];// id авторизированого пользователя

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page=1;
    }

    $notesOnPage = 2;
    $referencePoint= ($page - 1) * $notesOnPage;

    $query="SELECT text, users.id,  name, advert.id as ad_id, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id LIMIT $referencePoint, $notesOnPage";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $content='';
    for($arr=[]; $step = mysqli_fetch_assoc($result); $arr[]=$step);

    foreach($arr as $value){
        $text = $value['text'];
        $name = $value['name'];
        $phone_numb = $value['phone_numb'];
        $email = $value['email'];
        $ad_user_id= $value['id'];
        $ad_id = $value['ad_id'];

        
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
            if($user_id == $ad_user_id){
                
                $content.="<tr>
                                <td><form method='GET'>
                                <button><a href=\"?jump=$ad_id\">Top up</a></button>
                                </form></td>
                            </tr>";
            }
        $content.="</table><br>";
    }

    $query= "SELECT COUNT(*) as count FROM advert";//Подсчет кол-ва записей
    $count=mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
    $numbsOfPage= ceil($count/$notesOnPage);//кол-во страниц, число записей делим на желаемое на страницу
    //$content.= $numbsOfPage;

    if($page != 1){
        $previous = $page-1;
        $content.= "<a href=\"?page=$previous\"><<<</a>";//стрелки
    }

    for($i=1; $i <= $numbsOfPage; $i++){
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
$content = getList($link);

include 'layout.php';