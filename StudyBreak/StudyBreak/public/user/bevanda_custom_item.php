<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../bootstrap.php');

$templateParams['head-title'] = " - Costum";

$templateParams["foglio-di-stile"] = "../css/pages/custom_item.css";

$templateParams["title"] = "Study Break";

$showCustomParams["all-ingredients"] = $dbh->get_ingredients();
$showCustomParams["ingredients-relative-to-item"] = null;
$showCustomParams["infusion-name"]="";
if(isset($_GET['id'])){
    $showCustomParams["ingredients-relative-to-item"] = $dbh->get_ingredients_from_bevanda($_GET['id']);
    $bevandaCustom=$dbh->get_custom_from_id($_GET['id'],$_SESSION['idUtenteLogged']);
    $showCustomParams["infusion-name"]=$bevandaCustom[0]->nome;
}
$templateParams["main-content"] = 'alternativePagesTemplate/custom_show_main.php';
$templateJs[] = "delete_custom_item.js";
$templateParams["showCustomParams"] = $showCustomParams;


require '../../utilities/templates/base.php';
?>