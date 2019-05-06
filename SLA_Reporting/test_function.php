<?php
require_once 'Business_datetime.php';
require_once 'Holiday/Calculator.php';
require_once 'Holiday/Holiday.php';
require_once 'Holiday/Germany.php';
require_once 'Holiday/Bavaria.php';
require_once 'test/Holiday/BavariaTest.php';
require_once 'bavaria_holidays.php';
include_once 'function.php';
// test für is_business_time in Business.php
function test_is_business_time() {
    $b = new Business_Datetime();
    $d1 = "01/01/2010 13:30";
    $d2 = "01/01/2018 20:30";
    $d3 = "10/16/2018 19:30";
    $d4 = "10/16/2018 12:30";
    $d5 = "10/16/2018 13:30";
    
    echo 'Time: '.$d1.' is : false ->'.$b->is_business_time($d1)."<br>";
    echo 'Time: '.$d2.' is : false ->'.$b->is_business_time($d2)."<br>";
    echo 'Time: '.$d3.' is : false ->'.$b->is_business_time($d3)."<br>";
    echo 'Time: '.$d4.' is : false ->'.$b->is_business_time($d4)."<br>";
    echo 'Time: '.$d5.' is : true ->'.$b->is_business_time($d5)."<br>";
    echo 'false: '.false."<br>";
    echo 'true: '.true."<br>";
    echo '<span style="color:red;text-align:center;">test!</span>';
}
// test_is_business_time();

// test für is_the_same_date in Business.php
function test_is_the_same_date() {
    $b = new Business_Datetime();
    $d11 = "01/01/2010 13:30";
    $d12 = "01/01/2018 13:30";
    $d21 = "10/16/2018 13:30";
    $d22 = "10/16/2010 13:30";
    $d31 = "10/16/2018 13:30";
    $d32 = "10/16/2018 13:30";
    
    echo 'Time: '.$d11.' - '.$d12.' is : false ->'.$b->is_the_same_date($d11, $d12)."<br>";
    echo 'Time: '.$d21.' - '.$d22.' is : false ->'.$b->is_the_same_date($d21, $d22)."<br>";
    echo 'Time: '.$d31.' - '.$d32.' is : true ->'.$b->is_the_same_date($d31, $d32)."<br>";
    echo 'false: '.false."<br>";
    echo 'true: '.true."<br>";
    echo '<span style="color:red;text-align:center;">test!</span>';
}
// test_is_the_same_date();


// test für datetime_to_timestamp in function.php
function test_datetime_to_timestamp($datetime) {
    $timestamp = datetime_to_timestamp($datetime);
    echo 'Anfang Datum: '.$datetime.', timestamp: '.$timestamp."<br>";
    echo date('m/d/Y', $timestamp);
}
test_datetime_to_timestamp('18.10.2018');


