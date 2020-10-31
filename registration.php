<?php

include  'include.php';
include 'form.php';
$content='';
$formContent= registrationForm();


function registration($link){

    if(isset($_POST['name'])and isset($_POST['email']) and isset($_POST['phone'])
    and isset($_POST['login'])and isset($_POST['password']) and isset($_POST['confirm'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $login =$_POST['login'];
        $password= password_hash($_POST['password'], PASSWORD_DEFAULT);

        if($_POST['password'] == $_POST['confirm'] AND preg_match('#^[A-Za-z0-9]{6,15}$#', $_POST['password'])==1){//Проверка на совпадение пароля (1)

            $query="SELECT * FROM users WHERE login = '$login'";//Проверка на уникальность логина(2)
            $user= mysqli_fetch_assoc(mysqli_query($link, $query));

            if(empty($user) AND preg_match('#^[A-Za-z0-9_-]{4,12}$#', $login)==1){

                if(preg_match('#^[a-z0-9._-]{4,16}\@[a-z]{2,6}\.[a-z]{2,3}$#', $email)==1){//Проверка email(3)

            
                $query="INSERT INTO users (name, email, phone_numb, login, password, block_time, status, role)
                VALUE ('$name', '$email', '$phone', '$login', '$password', '0', 'active', 'user')";
                mysqli_query($link, $query) or die(mysqli_error($link));
            
                $_SESSION['message']= 'Регистрация прошла успешно, авторизируйтесь для входа на сайт';

                header('location: login.php');die();

                }else{
                    $_SESSION['message'] ='Ваш email не соответствует формату, пожалуйста проверьте введенный вами email';//(3)
                    //echo 'Ваш email не соответствует формату, пожалуйста проверьте введенный вами email';
                }
            }else{
                 $_SESSION['message']= 'Данный логин не соответствует требованиям:</br>
                1)Убедитесь что ваш логин состоит исключительно из символов латинского алфавита и цифр от 0 до 9</br>
                2)В инном случае, ваш логин занят другим пользователем, попробуйте изменить его!';//(2)
                
                //echo 'Данный логин не соответствует требованиям:</br>
                // 1)Убедитесь что ваш логин состоит исключительно из символов латинского алфавита и цифр от 0 до 9</br>
                // 2)В инном случае, ваш логин занят другим пользователем, попробуйте изменить его!';
           
            }

           
        }else{
            $_SESSION['message']= 'Ошибка регистрации пароля:</br>
            Убедитель в том что ваш пароль состоит из символов латинского алфавита, цифр от 0 до 9, и занимает от 4 до 12 символов</br>
            В противном случае проверьте соответсвует ли ваш пароль проверочному паролю!';//(1)
            //echo 'Ошибка регистрации пароля:</br>
            // Убедитель в том что ваш пароль состоит из символов латинского алфавита, цифр от 0 до 9, и занимает от 4 до 12 символов</br>
            // В противном случае проверьте соответсвует ли ваш пароль проверочному паролю!';
            
        }

        

    }else{
        if(isset($_POST['submit'])){
            $_SESSION['message']= 'Заполните все поля';
        }
    }

}
registration($link);


include 'layout.php';
