<?php

// var_dump($_GET);die;
// http://localhost:8080/SLA_Reporting/index.php
require_once 'Controller/Controller.php';
require_once 'function.php';
include_once 'Controller/cookie-authorization.php';
if (substr($_SERVER["REQUEST_URI"], - 1) !== '/') {
    $_SERVER["REQUEST_URI"] = $_SERVER["REQUEST_URI"] . '/';
}

$http_host = trim($_SERVER['PHP_SELF']);
$view = "View/";

$current_file = explode("/", $http_host);

$url_prefix = 'http://' . $_SERVER['HTTP_HOST'] . "/" . $current_file[1];

// var_dump($_SERVER);
// var_dump($url_prefix);

// create controller object
$con = new Controller($client);

if (! empty($_POST)) {
    if (count($_POST) > 0 && array_key_exists('data', $_POST)) {
        $report_data = explode(',', $_POST['data']);
    }
    $con->get_tickets($report_data);
}

// if (isset($_SERVER["PATH_INFO"])) {

if (isset($_SERVER["PATH_INFO"]) && $_SERVER["PATH_INFO"] == "/download") {
    include_once 'download.php';
} else {
    include_once $view . 'head.php';
    
    if (isset($_SERVER["PATH_INFO"])) {
        if ($_SERVER["PATH_INFO"] == "/table") {
            include_once $view . 'view_report.php';
        }
    } else {
        $_SERVER["PATH_INFO"] = "/index.php";
        include_once $view . 'start_form.php';
    }
    include_once $view . 'foot.php';
}
// }
// else {
// echo "Error: Uncorrect URL";
// }
?>

	