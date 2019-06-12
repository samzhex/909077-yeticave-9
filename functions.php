<?php
function format_price($number) {
    if ($number < 1000) {
        $output = $number;
    }
    else {
        $output = number_format($number , 0, '' , ' ');
    }
    return $output;   
}

function esc($string) {
	return  htmlspecialchars($string, ENT_QUOTES);	
}

function get_time_diff($date) {
    return $date - time();
}

function format_time_diff($deadline) {
    $date = strtotime($deadline);
    $time_diff = get_time_diff($date);
    $hours = floor($time_diff / 3600);
    $minutes = abs(floor(($time_diff % 3600) / 60));
    if(abs($hours) < 10) {
        $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
    }
    if($minutes < 10) {
        $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
    }
    return $hours . ':' . $minutes;
}

function show_breakpoint($deadline, $sec) {
    $date = strtotime($deadline);
    $time = get_time_diff($date);
    return $time <= $sec;
}

function check_date($dt_end) {
    $date = strtotime($dt_end);
    $now = time();
    $diff = $date - $now;
    return $diff <= 86400;
} 

function check_result($res, $link, $sql) {
    if (!$res) {
        print("Ошибка в запросе к БД. Запрос: $sql " . mysqli_error($link));
        die();
    }
}

function remaining_time($date) {
    $remaining_time = time() - strtotime($date);
    if ($remaining_time < 3600) {
        return intval($remaining_time/60) . ' ' . get_noun_plural_form($remaining_time/60, 'минута назад', 'минуты назад', 'минут назад');
    } else if ($remaining_time < 86400) {
        return intval($remaining_time/3600) . ' ' . get_noun_plural_form($remaining_time/3600, 'час назад', 'часа назад', 'часов назад');
    }
    return date('d.m.y', strtotime($date)) . ' в ' . date('H:i', strtotime($date)); 
}