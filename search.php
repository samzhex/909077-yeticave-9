<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

$lots = [];

if ($search) {
    $sql = 'SELECT l.id, l.title AS title, picture, price, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, (SELECT COUNT(*) FROM bets WHERE lot_id = l.id) AS bets_count, dt_end, c.title AS category FROM lots AS l LEFT JOIN categories AS c ON c.id = l.category_id WHERE MATCH(l.title, description) AGAINST(? IN BOOLEAN MODE)';
    $stmt = db_get_prepare_stmt($link, $sql, [$search . '*']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    check_result($result, $link, $sql);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $cur_page = intval($_GET['page'] ?? 1);
    $page_items = 9;
    $items_count = count($items);
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    $pages = range(1, $pages_count);

    $sql = 'SELECT l.id, l.title AS title, picture, price, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, (SELECT COUNT(*) FROM bets WHERE lot_id = l.id) AS bets_count, dt_end, c.title AS category FROM lots AS l LEFT JOIN categories AS c ON c.id = l.category_id WHERE MATCH(l.title, description) AGAINST(? IN BOOLEAN MODE) LIMIT ' . $page_items . ' OFFSET ' . $offset;
    $stmt = db_get_prepare_stmt($link, $sql, [$search . '*']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    check_result($result, $link, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$page_content = include_template('search.php', [
    'items' => $items ?? null,
    'lots' => $lots,
    'search' => $search,
    'categories' => $categories,
    'secs_in_hour' => $secs_in_hour,
    'pages' => $pages ?? null,
    'cur_page' => $cur_page ?? null
]);  

$layout_content = include_template('layout.php', [
    'content' => $page_content,  
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Результаты поиска',
    'search' => $search ?? null
]);

print($layout_content);