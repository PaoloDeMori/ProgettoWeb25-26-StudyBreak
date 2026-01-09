<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$templateParams["head-title"] = " - "."Cart Payment";
require_once('../bootstrap.php');

$templateParams["foglio-di-stile"] = "../css/pages/payment.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'alternativePagesTemplate/payment_main.php';

$templateJs[] = "formatCardPayment.js";

require '../../utilities/templates/base.php';
?>