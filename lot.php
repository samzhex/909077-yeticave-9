<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

if(!isset($_GET['id'])){
    http_response_code(404);
    die();
}

$lot_id = $_GET['id'];

$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');

if (!$link) {
    print('Ошибка MySQL: ' . mysqli_error($link));
    die();
} else {
    mysqli_set_charset($link, "utf8");
}

mysqli_set_charset($link, "utf8");

$sql = 'SELECT * FROM categories';
$result = mysqli_query($link, $sql);
if (!$result) {
    print("Ошибка в запросе к БД. Запрос: $sql " . mysqli_error($link));
    die();
}
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT l.id, l.title, description, picture, price, dt_end, step, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id WHERE l.id = ' . $lot_id;
$result = mysqli_query($link, $sql);
if (!$result) {
    print("Ошибка в запросе к БД. Запрос: $sql " . mysqli_error($link));
    die();
}
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
$lot = $lots[0];

if(!$lot){
    http_response_code(404);
    die();
}

$lot_content = include_template('lot.php', [
    'lot' => $lot, 
    'secs_in_hour' => $secs_in_hour
]);

$layout_content = include_template('layout.php', [
    'content' => $lot_content,  
    'categories' => $categories, 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
]);
print($layout_content);




