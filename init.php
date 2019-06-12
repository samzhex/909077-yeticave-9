<?php 
date_default_timezone_set('Europe/Moscow');
$secs_in_hour = 3600;
$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');
if (!$link) {
    print('Ошибка MySQL: ' . mysqli_error($link));
    die();
} 
mysqli_set_charset($link, "utf8");
$sql = 'SELECT * FROM categories';
$stmt = db_get_prepare_stmt($link, $sql, []);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
check_result($result, $link, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

session_start();
$user_name = null;
$user_id = null;

if (isset($_SESSION['user'])) {
    $user_name = $_SESSION['user']['name'];
    $user_id = intval($_SESSION['user']['id']);
}
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}