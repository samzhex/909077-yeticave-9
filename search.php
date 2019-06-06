<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

$search = $_GET['search'] ?? '';

$lots = [];

if ($search) {
    $sql = 'SELECT l.id, l.title AS title, picture, price, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, (SELECT COUNT(*) FROM bets WHERE lot_id = l.id) AS bets_count, dt_end, c.title AS category FROM lots AS l LEFT JOIN categories AS c ON c.id = l.category_id WHERE MATCH(l.title, description) AGAINST(? IN BOOLEAN MODE)';
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$lot_content = include_template('search.php', [
    'lots' => $lots ?? null,
    'search' => $search
]);  

$layout_content = include_template('layout.php', [
    'content' => $lot_content,  
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Результаты поиска',
    
]);

print($layout_content);