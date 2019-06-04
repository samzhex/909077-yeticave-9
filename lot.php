<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if(!isset($_GET['id'])){
    http_response_code(404);
    die();
}

$lot_id = $_GET['id'];

$sql = 'SELECT * FROM categories';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT l.id, l.title, description, picture, price, dt_end, step, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id WHERE l.id = ' . $lot_id;
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$lot = mysqli_fetch_array($result, MYSQLI_ASSOC);

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
    'user_name' => $user_name, 
    'title' => $lot['title']
]);

print($layout_content);




