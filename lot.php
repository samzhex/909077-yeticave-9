<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

if(isset($_GET['id'])){
    $lot_id = $_GET['id'];
}   else {
    http_response_code(404);
}

$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');

mysqli_set_charset($link, "utf8");

$sql = 'SELECT * FROM categories';
$categories = mysqli_query($link, $sql);

$sql = 'SELECT l.id, l.title, description, picture, price, dt_end, step, c.title AS category  FROM lots l LEFT JOIN categories c ON l.category_id = c.id';
$result = mysqli_query($link, $sql);
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

$lot = $lots[$lot_id-1];

$lot_content = include_template('lot.php', [
    'lot_title' => $lot['title'], 
    'category' => $lot['category'], 
    'description' => $lot['description'], 
    'picture' => $lot['picture'], 
    'price' => $lot['price'],
    'dt_end' => $lot['dt_end'],
    'step' => $lot['step']
]);

$layout_content = include_template('layout.php', [
    'content' => $lot_content,  
    'categories' => $categories, 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
    'title' => $lot_title
]);
print($layout_content);




