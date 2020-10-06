<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

$host='localhost';
$user='root';
$password='root';
$dbname='callboard';

$link= mysqli_connect($host, $user, $password, $dbname);
mysqli_query($link, "SET NAMES 'utf-8'");