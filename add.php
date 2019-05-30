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
    $required = ['title', 'description'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }
    
    if ($lot['category'] === 'select') {
        $errors['category'] = 'Выберите категорию';
    }
    
    if (isset($_FILES['lot_img']['name'])) {
        $tmp_name = $_FILES['lot_img']['tmp_name'];
        $path = $_FILES['lot_img']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== 'image/png' || $file_type !== 'image/jpeg') {
            $errors['picture'] = 'Загрузите картинку в формате PNG, JPEG или JPG';
        } else {
            $lot['picture'] = $path;
        }
    } else {
        $errors['picture'] = 'Вы не загрузили файл';
    }
    if (isset($lot['price'])) {
        if ($lot['price'] <= 0) {
            $errors['price'] = 'Содержимое поля «начальная цена» должно быть числом больше нуля';
        }
    } else {
        $errors['price'] = 'Это поле надо заполнить';
    }

    if (isset($lot['dt_end'])){
        if (!is_date_valid($lot['dt_end'])) {
            $errors['dt_end'] = 'Указанная дата должна быть больше текущей даты, хотя бы на один день и в формате «ГГГГ-ММ-ДД»';
        }
    } else {
        $errors['dt_end'] = 'Это поле надо заполнить';
    }
    
    if (isset($lot['step'])) {
        if ($lot['step'] <= 0) {
            $errors['step'] = 'Содержимое поля «шаг ставки» должно быть целым числом больше ноля';
        }
    } else {
        $errors['step'] = 'Это поле надо заполнить';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            'lot' => $lot,
            'errors' => $errors,
            'categories' => $categories
        ]);
    } else {
        move_uploaded_file($tmp_name, 'uploads/' . $path);
        $sql = 'INSERT INTO lots (title, description, picture, price, dt_end, step, user_id, category_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, [$lot['category'], $lot['title'], $lot['description'], $lot['picture'], $lot['price'], $lot['dt_end'], $lot['step']]);
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