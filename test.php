<?php
include 'include.php';
$form_content = '';
$content = '';

if(empty($_SESSION['id'])){
    $id = 5;
}else{
    $id = $_SESSION['id'];
}

$query= "SELECT block_time FROM users WHERE id = '$id'";
$result = mysqli_fetch_assoc(mysqli_query($link, $query));
$limit = $result['block_time'];


if(time() > $limit){
    echo 'go';
}else{
    echo 'stop';
}

echo time();
echo $limit;
//var_dump($limit);

include 'layout.php';