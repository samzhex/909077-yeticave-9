<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

$sql = "SELECT l.id, l.picture, l.title, l.dt_end, b.price, dt_bet, winner_id, (SELECT title FROM categories AS c WHERE l.category_id = c.id) AS category, (SELECT contacts FROM users AS u WHERE l.user_id = u.id) AS contacts FROM lots AS l LEFT JOIN bets AS b ON b.lot_id = l.id WHERE b.user_id = ? ORDER BY l.dt_end DESC";
$stmt = db_get_prepare_stmt($link, $sql, [$user_id]);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
check_result($res, $link, $sql);
$my_bets = mysqli_fetch_all($res, MYSQLI_ASSOC);

$page_content = include_template('my-bets.php', [
    'my_bets' => $my_bets,
    'secs_in_hour' => $secs_in_hour,
    'user_id' => $user_id
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Мои ставки',
    'search' => $search ?? null
]);
print($layout_content);