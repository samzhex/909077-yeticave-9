<?php 
date_default_timezone_set('Europe/Moscow');
$secs_in_hour = 3600;
$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');
if (!$link) {
    print('Ошибка MySQL: ' . mysqli_error($link));
    die();
} 
mysqli_set_charset($link, "utf8");
session_start();
$user_name = null;
$user_id = null;

if (isset($_SESSION['user'])) {
    $user_name = $_SESSION['user']['name'];
}