<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

if(!isset($_SESSION['user'])) {
    http_response_code(403);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $required = ['title', 'description'];
    $errors = [];
    
    foreach ($required as $key) {
        if (empty(trim($lot[$key]))) {
            $errors[$key] = 'Это поле надо заполнить';
        }
        if (strlen(trim($lot[$key])) > 200) {
            $errors[$key] = 'Превышено количество символов';
        }
    }
    
    if ($lot['category'] > count($categories) || $lot['category'] < 1) {
        $errors['category'] = 'Выберите категорию';
    }  
    
    if (!empty($_FILES['lot-img']['name'])) {
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $file_name = $_FILES['lot-img']['name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;
        $file_types = ['image/jpeg', 'image/png'];
        if (in_array(mime_content_type($tmp_name), $file_types)) {
            $lot['lot-img'] = $file_url;
        } else {
            $errors['lot-img'] = 'Загрузите картинку в формате PNG, JPEG или JPG';
        }
    } else {
        $errors['lot-img'] = 'Вы не загрузили файл';
    }

    if (!empty($lot['lot-rate'])) {
        if ($lot['lot-rate'] <= 0) {
            $errors['lot-rate'] = 'Содержимое поля «начальная цена» должно быть числом больше нуля';
        }
    } else {
        $errors['lot-rate'] = 'Это поле надо заполнить';
    }

    if (!empty($lot['lot-date'])){
        if (!is_date_valid($lot['lot-date']) || check_date($lot['lot-date'])) {
            $errors['lot-date'] = 'Указанная дата должна быть больше текущей даты, хотя бы на один день и в формате «ГГГГ-ММ-ДД»';
        }
    } else {
        $errors['lot-date'] = 'Это поле надо заполнить';
    }
    
    if (!empty ($lot['lot-step'])) {
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
            'error' => 'Пожалуйста, исправьте ошибки в форме.',
            'categories' => $categories
        ]);
    } else {
        move_uploaded_file($_FILES['lot-img']['tmp_name'], $file_path . $file_name);
        $sql = 'INSERT INTO lots (dt_add, user_id, category_id, title, description, picture, price, dt_end, step) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$user_id, $lot['category'], $lot['title'], $lot['description'], $lot['lot-img'], $lot['lot-rate'], $lot['lot-date'], $lot['lot-step']]);
        $res = mysqli_stmt_execute($stmt);
        if($res) {
            $lot_id = mysqli_insert_id($link);
            header('Location: lot.php?id=' . $lot_id);
            $page_content = include_template('lot.php', [
                'lot' => $lot,
            ]);
            die();
        } else {
            $page_content = include_template('add.php', [
                'lot' => $lot,
                'errors' => $errors,
                'error' => 'Что-то пошло не так.' ?? null,
                'categories' => $categories
            ]);
        }
    }

} else {
    $page_content = include_template('add.php', [
        'categories' => $categories, 
        'error' => 'Что-то пошло не так.' ?? null
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'categories' => $categories, 
    'user_name' => $user_name, 
    'title' => 'Добавление лота',
    'search' => $search ?? null
]);

print($layout_content);