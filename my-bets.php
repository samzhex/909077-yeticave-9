<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

$sql = "SELECT l.id, l.picture, l.title, l.dt_end, b.price, dt_bet, winner_id, (SELECT title FROM categories AS c WHERE l.category_id = c.id) AS category FROM lots AS l LEFT JOIN bets AS b ON b.lot_id = l.id WHERE b.user_id = $user_id ORDER BY l.dt_end DESC";
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$my_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);

$page_content = include_template('my-bets.php', [
    'my_bets' => $my_bets,
    'secs_in_hour' => $secs_in_hour
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Мои ставки'
]);
print($layout_content);