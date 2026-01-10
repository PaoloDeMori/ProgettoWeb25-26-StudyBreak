<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$templateParams["head-title"] = " - "."Analytics";
require_once('../bootstrap.php');


$templateParams["foglio-di-stile"] = "../css/pages/info.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'admin/analytics_main.php';

$analyticsParams["orders-last-month"] = $adminDbh->get_orders_last_month();
$analyticsParams["guadagno_last_month"] = $adminDbh->get_total_guadagno_last_month();
$analyticsParams["bevande-poca-quantita"] = $adminDbh->get_bevande_poca_quantita();




require '../../utilities/templates/base.php';
?>