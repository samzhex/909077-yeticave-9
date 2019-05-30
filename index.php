<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');

if (!$link) {
    print('Ошибка MySQL: ' . mysqli_error($link));
    die();
} 
mysqli_set_charset($link, "utf8");

$sql = 'SELECT * FROM categories';

$result = mysqli_query($link, $sql);
if (!$result) {
    print("Ошибка в запросе к БД. Запрос: $sql " . mysqli_error($link));
    die();
}

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT l.id AS id, l.title, picture, price, dt_end, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id ORDER BY l.dt_add DESC';
$result = mysqli_query($link, $sql);
if (!$result) {
    print("Ошибка в запросе к БД. Запрос: $sql " . mysqli_error($link));
    die();
}

$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
