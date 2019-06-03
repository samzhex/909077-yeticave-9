<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

$sql = 'SELECT * FROM categories';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT l.id AS id, l.title, picture, price, dt_end, c.title AS category  FROM lots AS l LEFT JOIN categories AS c ON l.category_id = c.id ORDER BY l.dt_add DESC';
$result = mysqli_query($link, $sql);
check_result($result, $link, $sql);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password'];
    $errors = [];
    foreach($required as $field) {
        if(empty($form[$field])) {
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
			$errors['password'] = 'Неверный пароль';
		}
    } else {
		$errors['email'] = 'Такой пользователь не найден';
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
    if (isset($_SESSION['user'])) {
        header ('Location: /');
    }
    else {
        $page_content = include_template('login.php', []);
    }
}


$page_content = include_template('login.php', []);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Вход'
]);
print($layout_content);

