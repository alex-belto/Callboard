<?php
include 'include.php';
$formContent = '';

function getUsers($link){
    $content = '';
    $formContent = '';

    $query = "SELECT id, name, status, role FROM users";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    for($arr = []; $step = mysqli_fetch_assoc($result); $arr[] = $step);

    foreach($arr as $value){
       $id = $value['id'];
       $name =  $value['name'];
       $status = $value['status'];
       $role = $value['role'];

       $content .= "<table border='1px solid black' cellspacing='0' width='600px'>";
       $content .= "<tr>
                        <td width='200px'>$name</td>
                        <td width='98px'>$status</td>
                        <td width='100px'>$role</td>";
                        $content.= "
                        <td><form method='GET'>";
                            if($status == 'active'){  
                        $content.="<a href=\"?banUserId=$id\">Забанить </a>";
                            }else{
                        $content.= "<a href=\"?unbanUserId=$id\">Разбанить </a>";
                            }
                        $content .= "</form></td>";
                        $content .= "<td><form method='GET'>
                                    <select name='role'>
                                        <option value='user'>user</option>
                                        <option value='moderator'>moderator</option>
                                    </select>
                                    <input type='hidden' name='id' value=\"$id\">
                                    <input type='submit' value='Отправить'>
                                    </td></form>";
       $content .= "</table>";
    }
    return $content;
}

function changeRole($link){
    if(isset($_GET['role']) AND isset($_GET['id'])){
        $newRole = $_GET['role'];
        $id = $_GET['id'];

        $query = "UPDATE users SET role = '$newRole' WHERE id = '$id'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['message'] = 'Роль пользователя была изменена!';
    }
}

changeRole($link);
$content = getUsers($link);

include 'layout.php';