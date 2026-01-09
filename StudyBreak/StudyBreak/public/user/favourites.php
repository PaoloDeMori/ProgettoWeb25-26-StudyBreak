<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$mainPagesParams['head-name'] = "Favourites";
$templateParams["head-title"] = " - ".$mainPagesParams['head-name'];
require_once('../bootstrap.php');

$templateParams["foglio-di-stile"] = "../css/pages/favourites.css";

$templateParams["title"] = "Study Break";

$templateParams["nav"] = "mainPagesTemplate/main_nav.php";

$templateParams["main-content"] = 'mainPagesTemplate/main_pages_template.php';

$mainPagesParams["main"]="favourites_main.php";

$mainPagesParams["footer"]=null;

//$favouritesParams["articles"] = $favouritesDbh->get_favourites_articles($_SESSION['idUtenteLogged']);
$favouritesParams["customs"] = $favouritesDbh->get_my_custom_articles($_SESSION['idUtenteLogged']);

$templateJs[] = "favourites.js";
$templateJs[] = "like.js";

require '../../utilities/templates/base.php';
?>