<?php
use Holiday\Holiday;
require_once 'bavaria_holidays.php';
require_once 'Business_datetime.php';

// echo 123;
// $a = '2017-12-12 00:00';
// $b = '2017-12-01 00:00';
// $business = new Business();
// $business->get_business_time_duration($a, $b);

//caculate how long is the business time between a and b


function miliseconds_to_datetime($timestamp, $format = 'm/d/Y H:i:s') {
    $dt = new DateTime();
    $dt->setTimestamp(time());
    $dt->setTimestamp($timestamp/1000);
    $dt->setTimezone(new DateTimeZone("Europe/Berlin"));
    $would_be = $dt->format($format);
    return $would_be;
}

function get_datetime_array($timestamp) {
    $dt = new DateTime();
    $dt->setTimestamp($timestamp);
    $dt->setTimezone(new DateTimeZone("Europe/Berlin"));
    $d = $dt->format("m");
    $m = $dt->format("d");
    $Y = $dt->format("Y");
    $H = $dt->format("H");
    $i = $dt->format("i");
    $s = $dt->format("s");
    $res['m'] = $m;
    $res['d'] = $d;
    $res['Y'] = $Y;
    $res['H'] = $H;
    $res['i'] = $i;
    $res['s'] = $s;
    return $res;
}

function get_year($datetime) {
    $dt = new DateTime();
    $dt->setTimestamp(datetime_to_timestamp($datetime));
//     $dt->setTimezone(new DateTimeZone("Europe/Berlin"));
    $Y = $dt->format("Y");
    $res = $Y;
    return $res;
}

function datetime_to_timestamp($datetime) {
//     $date = new DateTime("1899-12-31");
    $date = new DateTime($datetime);
    // "-2209078800"
    $date->format("U");
    // false
    return $date->getTimestamp();
}

/**
 * 
 * @param string $datetime Y-m-d 
 * @return string
 */
function get_holiday_format(string $datetime) {
    if (strpos($datetime, '-') !== false) {
        $dt = explode(' ', $datetime);
        $d = explode('-', $dt[0]);
        $res = $d['1'].'/'.$d['2'].'/'.$d['0'].' 00:00:00.000000';
    }
    return $res;
}


function get_time_difference($datetime1, $datetime2) {
//     $start_date = new DateTime('10/16/2018 13:30');
//     $since_start = $start_date->diff(new DateTime('10/16/2018 13:28'));
    $start_date = new DateTime($datetime1);
    $since_start = $start_date->diff(new DateTime($datetime2));
    $res['years'] = $since_start->y;
    $res['months'] = $since_start->m;
    $res['days'] = $since_start->d;
    $res['hours'] = $since_start->h;
    $res['minutes'] = $since_start->i;
    $res['seconds'] = $since_start->s;
    $res['days total'] = $since_start->days;
//     echo "<pre>"; var_dump($res);
    return $res;
}