<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

if(!isset($_GET['id'])){
    http_response_code(404);
    die();

} else {

    $lot_id = $_GET['id'];

    $sql = 'SELECT l.id, l.title, description, picture, price, dt_end, step, (SELECT MAX(price) FROM bets WHERE lot_id = l.id) AS bid_price, user_id, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id WHERE l.id = ?';
    $stmt = db_get_prepare_stmt($link, $sql, [$lot_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    check_result($res, $link, $sql);
    $lot = mysqli_fetch_array($res, MYSQLI_ASSOC);
   
    if(!$lot){
        http_response_code(404);
        die();

    } else {

        if(isset($lot['bid_price'])) {
            $lot['min_bet'] = $lot['step'] + $lot['bid_price'];
        } else {
            $lot['min_bet'] = $lot['step'] + $lot['price'];
        }

        $sql = "SELECT dt_bet, b.price, b.user_id AS user_id, u.name AS name FROM bets AS b LEFT JOIN users AS u ON b.user_id = u.id WHERE b.lot_id = ? ORDER BY price DESC";
        $stmt = db_get_prepare_stmt($link, $sql, [$lot_id]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        check_result($res, $link, $sql);
        $bets = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if ($bets) {
            $max_bet = $bets[0];
        }
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
            'bets' => $bets ?? null,
            'max_bet' => $max_bet ?? null,
            'error' => $error ?? null,
            'secs_in_hour' => $secs_in_hour,
            'user_id' => $user_id
        ]); 
    
    } 

}

$layout_content = include_template('layout.php', [
    'content' => $lot_content,  
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => $lot['title'] ?? null,
    'search' => $search ?? null
]);

print($layout_content);




