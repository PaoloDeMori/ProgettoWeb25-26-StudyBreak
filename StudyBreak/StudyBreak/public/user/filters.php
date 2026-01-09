<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mainPagesParams['head-name'] = "Filters";
$templateParams["head-title"] = " - ".$mainPagesParams['head-name'];
require_once('../bootstrap.php');


$templateParams["foglio-di-stile"] = "../css/pages/filters.css";

$templateParams["title"] = "Study Break";

$templateParams["nav"] = "mainPagesTemplate/main_nav.php";

$templateParams["main-content"] = 'mainPagesTemplate/main_pages_template.php';

$mainPagesParams["main"]="filters_main.php";

$mainPagesParams["footer"]=null;


require '../../utilities/templates/base.php';
?>