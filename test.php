<?php
include 'include.php';
$form_content = '';
$content = '';

$query="SELECT position, user_id,  id FROM advert WHERE position = (SELECT MAX(position) FROM advert )"; //Достаю максимальную позицию
    $result = mysqli_fetch_assoc(mysqli_query($link, $query));
    $topPosition = $result['position']; //текущее максимальное положение
    $topId = $result['id'];//id максимальной позиции
    
    echo $topPosition;?> <br> <?php
    echo $topId;


include 'layout.php';