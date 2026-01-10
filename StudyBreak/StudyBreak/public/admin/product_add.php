<?php

$templateParams["head-title"] = " - "."Product Add";
require_once('../bootstrap.php');

$templateParams["foglio-di-stile"] = "../css/admin_pages/product_add.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'admin/main_pages_template.php';

$mainPagesParams["main"]="products/product_add_main.php";

$mainPagesParams["footer"]=null;

$templateJs[] = "previewImage.js";
$templateJs[] = "loadIngredient.js";

require '../../utilities/templates/base.php';
?>