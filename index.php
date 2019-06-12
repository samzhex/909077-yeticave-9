<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

$sql = 'SELECT l.id AS id, l.title, picture, l.price, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, (SELECT COUNT(*) FROM bets WHERE lot_id = l.id) AS bets_count, dt_end, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id WHERE dt_end > NOW() ORDER BY l.dt_add DESC';
$stmt = db_get_prepare_stmt($link, $sql, []);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
check_result($res, $link, $sql);
$lots = mysqli_fetch_all($res, MYSQLI_ASSOC);

$page_content = include_template('index.php', [
    'categories' => $categories, 
    'lots' => $lots,
    'secs_in_hour' => $secs_in_hour,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Главная',
    'search' => $search ?? null
]);

print($layout_content);
