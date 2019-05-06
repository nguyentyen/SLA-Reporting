<?php
require_once 'Holiday/Calculator.php';;
require_once 'Holiday/Holiday.php';;
require_once 'Holiday/Germany.php';
require_once 'Holiday/Bavaria.php';
require_once 'test/Holiday/BavariaTest.php';
use Holiday\Bavaria;




$b = new Bavaria();

echo "<pre>";

$d = $b->get_holidays_bavaria(2018);

print_r($d);
$i=0;
foreach ($d as $value) {
    print_r($value->date);
    echo ($i++)."---------";
}


































die;
// $year = 1538633332002/31556926 % 12;
// echo $year."-------------";
// echo date('m/d/Y H:i:s', 1538633332002);
// echo date("m/d/Y H:i:s", (1227643821310   / 1000) );
// $t = explode(" ",microtime());
// echo date("m-d-y H:i:s");


//datetime rechnen
// IXBY-5:
// $timestamp = strtotime($datetime);
// var_dump($timestamp);
// echo "1:".strtotime("10/08/2018 11:26:14") < time()."<br>";
// 10-16-2018 09:14
// echo "2:".strtotime("10/16/2018 09:14")."<br>";
// 10/16/2018
// 10/08/2018
echo "10/16/2018<10/08/2018"; 
var_dump("10/16/2018"<"10/08/2018")."<br>";
echo "10/16/2018>10/08/2018"; 
var_dump("10/16/2018">"10/08/2018")."<br>";
echo "07/16/2018<10/08/2018"; 
var_dump("07/16/2018"<"10/08/2018")."<br>";
echo "07/16/2018>10/08/2018";
var_dump("07/16/2018">"10/08/2018")."<br>";
echo "07/01/2018<07/02/2018";
var_dump("07/01/2018"<"07/02/2018")."<br>";
echo "\n";
die;
echo "10/16/2018<10/08/2018";
var_dump("10/16/2018"<"10/08/2018")."<br>";
echo "10/16/2018>10/08/2018";
var_dump("10/16/2018">"10/08/2018")."<br>";
echo "7/16/2018<10/08/2018";
var_dump("7/16/2018"<"10/08/2018")."<br>";
echo "7/16/2018>10/08/2018";
var_dump("7/16/2018">"10/08/2018")."<br>";


$now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
// echo $now->format("m-d-Y H:i:s.u") . '<br>';
$local = $now->setTimeZone(new DateTimeZone('Europe/Berlin'));
echo $local->format("m/d/Y H:i:s.u") . '<br>';
// echo $local->format("m") . '<br>';

echo time();

die;
$created = 1538990774003; //08 Oct 2018 11:26
$date = "10-08-2018 11:26:14";
// echo 1538990774003;
$c = 1533900374;

$t = strtotime($date);

// 1538990774003 zu 08 Oct 2018 11:26
$dt = new DateTime();
$dt->setTimestamp(time());
$dt->setTimestamp($created/1000);
$dt->setTimezone(new DateTimeZone("Europe/Berlin"));
$would_be = $dt->format('m/d/Y H:i:s');
echo $would_be;
echo "<br>";
// 10/08/2018 11:26:14 zu 538990774003
echo strtotime("10/08/2018 11:26:14");
echo "<br>";
// 538990774003 zu 10/08/2018 11:26:14
$dt = new DateTime();
$dt->setTimestamp(time());
$dt->setTimestamp(538990774003);
// $dt->setTimezone(new DateTimeZone("Europe/Berlin"));
$would_be = $dt->format('m/d/Y H:i:s');
echo $would_be;
echo "<br>";





die;
$dt = new DateTime();
$dt->setTimestamp(time());
$dt->setTimestamp($created/1000);
$dt->setTimezone(new DateTimeZone("Europe/Berlin"));
$would_be = $dt->format('m-d-Y H:i:s.u');

var_dump($t);
var_dump($would_be);
$respond = 1539589084380; //15 Oct 2018 09:38
$resolved = 1539589084346; //15 Oct 2018 09:38

$dt->setTimestamp($c/1000);
$dt->setTimezone(new DateTimeZone("Europe/Berlin"));
$would_be = $dt->format('m-d-Y H:i:s.u');
var_dump($would_be);











die;


//current datetime
$now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
// echo $now->format("m-d-Y H:i:s.u") . '<br>';
$local = $now->setTimeZone(new DateTimeZone('Europe/Berlin'));
echo $local->format("m-d-Y H:i:s.u") . '<br>';
echo $local->format("m") . '<br>';
$d = $local->format("m");
$m = $local->format("d");
$Y = $local->format("Y");
$H = $local->format("H");
$i = $local->format("i");
$s = $local->format("s");
$local = "$m/$d/$Y $H:$m:$s";
die;


//timestamp to datetime
$dt = new DateTime();
$dt->setTimestamp(time());
$dt->setTimestamp(1538988240824/1000);
$dt->setTimezone(new DateTimeZone("Europe/Berlin"));
$would_be = $dt->format('m-d-Y H:i:s');
echo "Timestamp " . 1538988058743 . " is date " . $would_be .
" in users timezone " . $dt->getTimezone()->getName();
die;
