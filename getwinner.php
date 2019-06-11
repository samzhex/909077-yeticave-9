<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');
require_once('vendor/autoload.php');

$lots = [];

$sql = "SELECT l.title, l.id, (SELECT MAX(price) FROM bets AS b WHERE lot_id = l.id) AS bet_price, (SELECT user_id FROM bets WHERE price = bet_price) AS win_id, (SELECT name FROM users AS u WHERE u.id = win_id) AS winner_name, (SELECT email FROM users AS u WHERE u.id = win_id) AS winner_email FROM lots AS l WHERE dt_end < NOW() AND l.id IN (SELECT DISTINCT b.lot_id FROM bets b)";
$stmt = db_get_prepare_stmt($link, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
check_result($result, $link, $sql);
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($lots) {
    $transport = new Swift_SmtpTransport('phpdemo.ru', 25);
    $transport->setUsername('keks@phpdemo.ru');
    $transport->setPassword('htmlacademy');
    
    $mailer = new Swift_Mailer($transport);

    $logger = new Swift_Plugins_Loggers_ArrayLogger();
    $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

    foreach ($lots as $lot) {
        $message = new Swift_Message();
        $message->setSubject("Ваша ставка победила");
        $message->setFrom('keks@phpdemo.ru', 'yeticave');
        $message->setTo($lot['winner_email']);
        $msg_content = include_template('email.php', ['lot' => $lot]);
        $message->setBody($msg_content, 'text/html');

        $result = $mailer->send($message);
        $lot_id = $lot['id'];
        $winner_id = $lot['win_id'];
    
        if ($result) {
            print('Рассылка успешно отправлена');
            $sql = "UPDATE lots SET winner_id = $winner_id WHERE id = $lot_id";
            $res = mysqli_query($link, $sql);
            check_result($res, $link, $sql);
        }
        else {
            print("Не удалось отправить рассылку: " . $logger->dump());
        }
    }
}
