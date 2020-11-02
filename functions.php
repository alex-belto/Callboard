<?php 

function delete($link){
    if(isset($_GET['delAdId'])){

        $delAdId = $_GET['delAdId'];
        $query = "DELETE FROM advert WHERE id = '$delAdId'";//удаляю запись
        mysqli_query($link, $query) or die(mysqli_error($link));
        $query = "DELETE FROM comments WHERE ad_id = '$delAdId'";// удаляю коментарии к ней
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись удалена!';
    }
    if(isset($_GET['delCommentId'])){

        $delCommentId = $_GET['delCommentId'];
        $query = "DELETE FROM comments WHERE id = '$delCommentId'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись удалена!';
    }
}

function ban($link){
    if(isset($_GET['banUserId'])){
        $banUserId = $_GET['banUserId'];
        if($banUserId != 2){
        $query = "UPDATE users SET status = 'banned' WHERE id = '$banUserId'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Пользователь забанен !';
        }else{
            $_SESSION['message'] = 'У вас не достаточно полномочий что бы забанить администратора!';
        }
    }
    if(isset($_GET['unbanUserId'])){
        $unbanUserId = $_GET['unbanUserId'];
        $query = "UPDATE users SET status = 'active' WHERE id = '$unbanUserId'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Пользователь разбанен !';
    }
}

function editForm($link){
    if(isset($_GET['editAdId'])){
        $editAdId = $_GET['editAdId'];
        $query = "SELECT text FROM advert WHERE id = '$editAdId'";
        $result = mysqli_fetch_assoc(mysqli_query($link, $query));
        $text = $result['text'];

        return $formContent = "
    <form action='' method='POST'>
        <p>Внесите ваши правки:</p>
        <textarea name='editText' placeholder=''>$text</textarea><br><br>
        <input type='submit' name='submit' value='Отправить'>
    </form>";
        
    }
    if(isset($_GET['editCommentId'])){
        $editCommentId = $_GET['editCommentId'];
        $query = "SELECT text FROM comments WHERE id = '$editCommentId'";
        $result = mysqli_fetch_assoc(mysqli_query($link, $query));
        $text = $result['text'];

        return $formContent = "
    <form action='' method='POST'>
        <p>Внесите ваши правки:</p>
        <textarea name='editText' placeholder=''>$text</textarea><br><br>
        <input type='submit' name='submit' value='Отправить'>
    </form>";
    }
}

function edit($link, $location){
    if(isset($_GET['editAdId'])){
        $editAdId = $_GET['editAdId'];
    if(isset($_POST['editText'])){
        $updatedText = $_POST['editText'];
        $query = "UPDATE advert SET text = '$updatedText' WHERE id = '$editAdId'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись была изменена!';
        
        header("location: $location"); die();
        }
    }
    if(isset($_GET['editCommentId'])){
        $editCommentId = $_GET['editCommentId'];
    if(isset($_POST['editText'])){
        $updatedText = $_POST['editText'];
        $query = "UPDATE comments SET text = '$updatedText' WHERE id = '$editCommentId'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Запись была изменена!';
        
        header("location: $location"); die();
        }
    }
}