<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

$page_content = include_template('index.php', [
    'categories' => $categories, 
    'items' => $items
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
    'title' => 'Главная'
]);
print($layout_content);
