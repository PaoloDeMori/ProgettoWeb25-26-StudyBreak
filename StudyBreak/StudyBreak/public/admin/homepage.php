<?php

$mainPagesParams['head-name'] = "Homepage";
$templateParams["head-title"] = " - ".$mainPagesParams['head-name'];
require_once('../bootstrap.php');

$_SESSION['caffe'] = isset($_GET['caffe']);
$_SESSION['only-not-available'] = isset($_GET['available']);

$templateParams["foglio-di-stile"] = "../css/admin_pages/homepage.css";

$templateParams["title"] = "Study Break";

$templateParams["nav"] = "admin/admin_nav.php";

$templateParams["main-content"] = 'admin/main_pages_template.php';

$mainPagesParams["main"]="homepage/homepage_main.php";

$mainPagesParams["footer"]="homepage/homepage_footer.php";

$templateJs[] = "searchbar.js";
$templateJs[] = "displayAllProducts.js";

require '../../utilities/templates/base.php';
?>