<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../bootstrap.php');

$templateParams['head-title'] = " - Costumize Item";

$templateParams["foglio-di-stile"] = "../css/pages/create.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'alternativePagesTemplate/create_item_main.php';

$createParams["all-ingredients"] = $dbh->get_ingredients();
$createParams["ingredients-relative-to-item"] = null;
if(isset($_GET['id'])){
    $createParams["ingredients-relative-to-item"] = $dbh->get_ingredients_from_bevanda($_GET['id']);
}


require '../../utilities/templates/base.php';
?>