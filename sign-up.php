<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

$tpl_data = [];

$sql = 'SELECT * FROM categories';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password', 'name', 'contacts'];
    $errors = [];
    foreach ($required as $field) {
        if (empty(trim($form[$field]))) {
            $errors[$field] = 'Не заполнено поле';
        }
        if ($field === 'name' || $field === 'email') {
            $limit = 50;
        } else {
            $limit = 200;
        }
        if (strlen(trim($form[$field])) > $limit) {
            $errors[$field] = 'Превышено количество символов';
        }
    }

    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите e-mail';
    }

    if (empty($errors)) {
        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $res = mysqli_query($link, $sql);
        check_result($res, $link, $sql);
        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);
            $sql = 'INSERT INTO users (email, name, password, contacts) VALUES (?, ?, ?, ?)'; 
            $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password, $form['contacts']]);
            $res = mysqli_stmt_execute($stmt);
            check_result($res, $link, $sql);
        }
        if ($res && empty($errors)) {
            header('Location: /login.php');
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
    'user_name' => $user_name, 
    'title' => 'Регистрация'
]);
print($layout_content);