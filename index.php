<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

$sql = 'SELECT l.id AS id, l.title, picture, l.price, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, (SELECT COUNT(*) FROM bets WHERE lot_id = l.id) AS bets_count, dt_end, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id WHERE dt_end > NOW() ORDER BY l.dt_add DESC';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

$page_content = include_template('index.php', [
    'categories' => $categories, 
    'lots' => $lots,
    'secs_in_hour' => $secs_in_hour,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Главная'
]);

print($layout_content);
