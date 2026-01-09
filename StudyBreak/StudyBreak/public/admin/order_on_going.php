<?php 
$mainPagesParams['head-name'] = "Homepage";
$templateParams["head-title"] = " - ".$mainPagesParams['head-name'];
require_once('../bootstrap.php');


$templateParams["foglio-di-stile"] = "../css/admin_pages/orders.css";

$templateParams["title"] = "Study Break";

$ordersParams["ordersList"] = $adminDbh->get_orders_by_user(ON_GOING);

$templateParams["nav"] = "admin/admin_nav.php";

$templateParams["main-content"] = 'admin/main_pages_template.php';

$mainPagesParams["main"]="orders/orders_main.php";

$mainPagesParams["footer"]=null;

$ordersParams["status"]='ongoing';

require '../../utilities/templates/base.php';
?>