<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

if (isset($_SESSION['user'])) {
    header ('Location: /');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = [];
    foreach($required as $field) {
        if(empty(trim($form[$field]))) {
            $errors[$field] = 'Это поле надо заполнить';
        }   
    }
    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = db_get_prepare_stmt($link, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    check_result($res, $link, $sql);
    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    
    if (!count($errors) && $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
			$errors['err'] = 'Неверное имя пользователя или пароль';
		}
    } else {
		$errors['err'] = 'Неверное имя пользователя или пароль';
    }
    if (count($errors) === 0) {
        header('Location: /login.php');
        exit();
    }
    
    $page_content = include_template('login.php', [
        'form' => $form, 
        'errors' => $errors
    ]);
} else {
    $page_content = include_template('login.php', []);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Вход',
    'search' => $search ?? null
]);
print($layout_content);

