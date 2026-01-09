<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$templateParams["head-title"] = " - "."Orders on going";
require_once('../bootstrap.php');


$templateParams["foglio-di-stile"] = "../css/pages/order.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'alternativePagesTemplate/orders_main.php';

$ordersParams["ordersList"] = $dbh->get_orders_by_user($_SESSION['idUtenteLogged'],HISTORY);
$ordersParams["status"]='HISTORY';


require '../../utilities/templates/base.php';
?>