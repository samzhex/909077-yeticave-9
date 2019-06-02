<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

$tpl_data = [];

$link = mysqli_connect('localhost:8889', 'root', 'root', 'yeticave');

if (!$link) {
    print('Ошибка MySQL: ' . mysqli_error($link));
    die();
} 
mysqli_set_charset($link, "utf8");

$sql = 'SELECT * FROM categories';

$result = mysqli_query($link, $sql);
if (!$result) {
    print("Ошибка в запросе к БД. Запрос: $sql " . mysqli_error($link));
    die();
}

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['password', 'name', 'message'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Не заполнено поле';
        }
    }

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите e-mail';
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);
            $sql = 'INSERT INTO users (dt_create, email, name, password, contacts) VALUES (NOW(), ?, ?, ?, ?)'; 
            $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password, $form['message']]);
            $res = mysqli_stmt_execute($stmt);
        }
        if ($res && empty($errors)) {
            header('Location: /pages/login.html');
            exit();
        }
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['values'] = $form;
}
$page_content = include_template('sign-up.php', $tpl_data);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
    'title' => 'Регистрация'
]);
print($layout_content);