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
    $time_diff_sec = $date - strtotime('now');
    return $time_diff_sec;
}

function show_breakpoint($time) {
    if ($time <= $sec_in_hour) {
        return true;
    } else {
        return false;
    }
}

