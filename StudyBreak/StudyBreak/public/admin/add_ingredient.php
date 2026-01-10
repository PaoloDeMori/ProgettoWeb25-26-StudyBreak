<?php
require_once('../bootstrap.php');

$templateParams['head-title'] = " - Costumize Item";

$templateParams["foglio-di-stile"] = "../css/pages/create.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'admin/products/select_ingredient_main.php';

$createParams["all-ingredients"] = $dbh->get_ingredients();

$templateJs[] = "saveIngredientList.js";

require '../../utilities/templates/base.php';
?>