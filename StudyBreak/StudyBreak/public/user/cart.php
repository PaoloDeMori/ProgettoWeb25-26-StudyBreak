<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$mainPagesParams['head-name'] = "Cart";
$templateParams["head-title"] = " - ".$mainPagesParams['head-name'];
require_once('../bootstrap.php');

$templateParams["foglio-di-stile"] = "../css/pages/cart.css";

$templateParams["title"] = "Study Break";

$templateParams["nav"] = "mainPagesTemplate/main_nav.php";

$templateParams["main-content"] = 'mainPagesTemplate/main_pages_template.php';

$mainPagesParams["main"]="cart_main.php";

$mainPagesParams["footer"]="cart_footer.php";

$templateJs[] = "cart.js";
$templateJs[] = "deleteItemCart.js";

//$cartParams["articles"] = $cartDbh->getCart($_SESSION['idUtenteLogged']);

require '../../utilities/templates/base.php';
?>