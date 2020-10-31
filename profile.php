<?php


if(!isset($_SESSION['id'])){
$_SESSION['id'] = '5';
$_SESSION['name'] = 'guest';
$_SESSION['login'] = 'guest';
$_SESSION['phoneNumb'] = '';
$_SESSION['email'] = '';
$_SESSION['status'] = 'active';
$_SESSION['role'] = 'guest';
}