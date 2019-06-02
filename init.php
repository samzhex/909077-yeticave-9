<?php 
$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');
if (!$link) {
    print('Ошибка MySQL: ' . mysqli_error($link));
    die();
} 
mysqli_set_charset($link, "utf8");