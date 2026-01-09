<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../bootstrap.php');

$mainPagesParams['head-name'] = "Custom";

$templateParams["foglio-di-stile"] = "../css/pages/costumize_item.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'alternativePagesTemplate/customize_item_main.php';

$templateJs[] = "customize.js";

require('../../utilities/templates/mainPagesTemplate/main_pages_template.php');

require '../../utilities/templates/base.php';
?>