<?php
function format_price($number) {
    if ($number < 1000) {
        $output = $number;
    }
    else {
        $output = number_format($number , 0, '' , ' ');
    }
    return $output . '<b class="rub">р</b>';   
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
    $minutes = floor(($time_diff % 3600) / 60);
    if($hours < 10) {
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

