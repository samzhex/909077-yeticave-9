<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

$sql = 'SELECT * FROM categories';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);
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
    if (count($errors)) {
		$page_content = include_template('login.php', [
            'form' => $form, 
            'errors' => $errors
        ]);
    } else {
        header('Location: /login.php');
        exit();
	}
} else {
    $page_content = include_template('login.php', []);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Вход'
]);
print($layout_content);

