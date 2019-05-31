<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

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
    $lot = $_POST;
    $required = ['lot-name', 'message'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    
    if ($lot['category'] === 'select') {
        $errors['category'] = 'Выберите категорию';
    }
    
    if (isset($_FILES['lot-img'])) {
        $file_name = $_FILES['lot-img']['name'];
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== 'image/jpeg') {
            $errors['lot-img'] = 'Загрузите картинку в формате PNG, JPEG или JPG';
        } else {
            $lot['lot-img'] = $file_url;
        }
    } else {
        $errors['lot-img'] = 'Вы не загрузили файл';
    }
    if (isset($lot['lot-rate'])) {
        if ($lot['lot-rate'] <= 0) {
            $errors['lot-rate'] = 'Содержимое поля «начальная цена» должно быть числом больше нуля';
        }
    } else {
        $errors['lot-rate'] = 'Это поле надо заполнить';
    }

    if (isset($lot['lot-date'])){
        if (!is_date_valid($lot['lot-date'])) {
            $errors['lot-date'] = 'Указанная дата должна быть больше текущей даты, хотя бы на один день и в формате «ГГГГ-ММ-ДД»';
        }
    } else {
        $errors['lot-date'] = 'Это поле надо заполнить';
    }
    
    if (isset($lot['lot-step'])) {
        if ($lot['lot-step'] <= 0) {
            $errors['lot-step'] = 'Содержимое поля «шаг ставки» должно быть целым числом больше ноля';
        }
    } else {
        $errors['lot-step'] = 'Это поле надо заполнить';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            'lot' => $lot,
            'errors' => $errors,
            'categories' => $categories
        ]);
    } else {
        move_uploaded_file($_FILES['lot-img']['tmp_name'], $file_path . $file_name);
        $sql = 'INSERT INTO lots (dt_add, user_id, category_id, title, description, picture, price, dt_end, step) VALUES (NOW(), 1, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, [$lot['category'], $lot['lot-name'], $lot['message'], $lot['lot-img'], $lot['lot-rate'], $lot['lot-date'], $lot['lot-step']]);
        $res = mysqli_stmt_execute($stmt);
        if($res) {
            $lot_id = mysqli_insert_id($link);
            header('Location: lot.php?id=' . $lot_id);
            $page_content = include_template('lot.php', [
                'lot' => $lot,
            ]);
            
        }
    }

} else {
    $page_content = include_template('add.php', [
        'categories' => $categories, 
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
    'title' => 'Добавление лота'
]);
print($layout_content);