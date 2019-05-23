<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');

mysqli_set_charset($link, "utf8");

$sql = 'SELECT * FROM categories';

$categories = mysqli_query($link, $sql);

$sql = 'SELECT l.id AS id, l.title, picture, price, dt_end, c.title AS category  FROM lots l LEFT JOIN categories c ON l.category_id = c.id ORDER BY l.dt_add DESC';
$items = mysqli_query($link, $sql);

$page_content = include_template('index.php', [
    'categories' => $categories, 
    'items' => $items,
    'secs_in_hour' => $secs_in_hour,

]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
    'title' => 'Главная'
]);
print($layout_content);
