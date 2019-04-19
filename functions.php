<?php
function format_price($number) {
    if ($number < 1000) {
        $output = $number;
    }
    else {
        $output = number_format($number , 0, '' , ' ');
    }
    return $output . ' ' . '<b class="rub">р</b>';   
}

function esc($string) {
	return  htmlspecialchars($string);	
}
?>

