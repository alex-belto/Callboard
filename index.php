<?php
include 'include.php';
$form_content='';
function getList($link){

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page=1;
    }

    $notesOnPage = 4;
    $referencePoint= ($page - 1) * $notesOnPage;

    $query="SELECT text, name, phone_numb, email FROM users
    RIGHT JOIN advert ON users.id = advert.user_id LIMIT $referencePoint, $notesOnPage";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $content='';
    for($arr=[]; $step = mysqli_fetch_assoc($result); $arr[]=$step);

    foreach($arr as $value){
        $text = $value['text'];
        $name = $value['name'];
        $phone_numb = $value['phone_numb'];
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
                    <td>$phone_numb</td>
                </tr>
                <tr>
                    <td>$email</td>
                </tr>
                
            </table><br>";
    }

    $query= "SELECT COUNT(*) as count FROM advert";//Подсчет кол-ва записей
    $count=mysqli_fetch_assoc(mysqli_query($link, $query))['count'];
    $numbsOfPage= ceil($count/$notesOnPage);//кол-во страниц, число записей делим на желаемое на страницу
    $content.= $numbsOfPage;


    return $content;
}

$content = getList($link);

include 'layout.php';