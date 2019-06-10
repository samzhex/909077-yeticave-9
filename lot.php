<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if(!isset($_GET['id'])){
    http_response_code(404);
    die();
}

$lot_id = $_GET['id'];

$sql = 'SELECT l.id, l.title, description, picture, price, dt_end, step, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id WHERE l.id = ' . $lot_id;
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$lot = mysqli_fetch_array($result, MYSQLI_ASSOC);

if(isset($lot['bid_price'])) {
    $lot['min_bet'] = $lot['step'] + $lot['bid_price'];
} else {
    $lot['min_bet'] = $lot['step'] + $lot['price'];
}

if(!$lot){
    http_response_code(404);
    die();
}

$sql = "SELECT dt_bet, b.price, u.name AS name FROM bets AS b LEFT JOIN users AS u ON b.user_id = u.id WHERE b.lot_id = $lot_id ORDER BY price DESC";
$result = $result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$bets = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $my_bet = $_POST;
    $error = '';
    if (empty(trim($my_bet['cost']))) {
        $error = 'Введите ставку';
    }
    if (empty($error) && $my_bet['cost'] < $lot['min_bet']) {
        $error = 'Мин. ставка ' . $lot['min_bet'] . ' р';
    }
    if (empty($error)) {
        $sql = 'INSERT INTO bets (price, user_id, lot_id) VALUES (?, ?, ?)'; 
        $stmt = db_get_prepare_stmt($link, $sql, [$my_bet['cost'], $user_id, $lot_id]);
        $res = mysqli_stmt_execute($stmt);
        check_result($res, $link, $sql);
        if ($res && empty($error)) {
            header('Location: /lot.php?id=' . $lot_id);
            exit();
        }
    }
} 

$lot_content = include_template('lot.php', [
    'lot' => $lot, 
    'bets' => $bets,
    'error' => $error ?? null
]);  

$layout_content = include_template('layout.php', [
    'content' => $lot_content,  
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => $lot['title']
]);

print($layout_content);




