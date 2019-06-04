<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

$sql = 'SELECT * FROM categories';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT l.id AS id, l.title, picture, price, dt_end, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id ORDER BY l.dt_add DESC';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

$page_content = include_template('index.php', [
    'categories' => $categories, 
    'items' => $items,
    'secs_in_hour' => $secs_in_hour,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Главная'
]);

print($layout_content);
