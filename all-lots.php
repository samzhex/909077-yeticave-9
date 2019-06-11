<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

$cur_cat = $_GET['category_id'];

if ($cur_cat) {
    $sql = "SELECT l.id AS id, l.title, picture, price, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, (SELECT COUNT(*) FROM bets WHERE lot_id = l.id) AS bets_count, dt_end, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id WHERE c.id = ? ORDER BY l.dt_add DESC";
    $stmt = db_get_prepare_stmt($link, $sql, [$cur_cat]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    check_result($result, $link, $sql);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;
    $items_count = count($items);
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    $pages = range(1, $pages_count);

    $sql = "SELECT l.id AS id, l.title, picture, price, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, (SELECT COUNT(*) FROM bets WHERE lot_id = l.id) AS bets_count, dt_end, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id  WHERE c.id = ? ORDER BY l.dt_add DESC LIMIT $page_items OFFSET $offset";
    $stmt = db_get_prepare_stmt($link, $sql, [$cur_cat]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    check_result($result, $link, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "SELECT title FROM categories AS c WHERE c.id = $cur_cat";
    $result = mysqli_query($link, $sql);
    check_result($result, $link, $sql);
    $cur_category = mysqli_fetch_array($result, MYSQLI_ASSOC);
}

$page_content = include_template('all-lots.php', [
    'categories' => $categories, 
    'lots' => $lots ?? null,
    'secs_in_hour' => $secs_in_hour,
    'items' => $items ?? null,
    'cur_category' => $cur_category['title'],
    'pages' => $pages ?? null,
    'cur_page' => $cur_page ?? null,
    'cur_cat' => $cur_cat
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Все лоты'
]);

print($layout_content);
