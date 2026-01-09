<?php 

$mainPagesParams['head-name'] = "Filters";
$templateParams["head-title"] = " - ".$mainPagesParams['head-name'];
require_once('../bootstrap.php');


$templateParams["foglio-di-stile"] = "../css/pages/filters.css";

$templateParams["title"] = "Study Break";

$templateParams["nav"] = "admin/admin_nav.php";

$templateParams["main-content"] = 'admin/main_pages_template.php';

$mainPagesParams["main"]="filters_main.php";

$mainPagesParams["footer"]=null;


require '../../utilities/templates/base.php';
?>