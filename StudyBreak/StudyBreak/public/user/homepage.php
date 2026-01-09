<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mainPagesParams['head-name'] = "Homepage";
$templateParams["head-title"] = " - ".$mainPagesParams['head-name'];
require_once('../bootstrap.php');

$_SESSION['caffe'] = isset($_GET['caffe']);
$_SESSION['only-not-available'] = isset($_GET['available']);

$templateParams["foglio-di-stile"] = "../css/pages/home.css";

$templateParams["title"] = "Study Break";

$templateParams["nav"] = "mainPagesTemplate/main_nav.php";

$templateParams["main-content"] = 'mainPagesTemplate/main_pages_template.php';

$mainPagesParams["main"]="homepage_main.php";

$mainPagesParams["footer"]="homepage_footer.php";

//$homeParams["articles"] = $dbh->get_most_ordered_articles(null,null,$_SESSION['caffe'] ,$_SESSION['only-not-available']);

$templateJs[] = "searchbar.js";
$templateJs[] = "bestProducts.js";
$templateJs[] = "like.js";

require '../../utilities/templates/base.php';
?>