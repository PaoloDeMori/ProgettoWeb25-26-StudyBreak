<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$templateParams["head-title"] = " - "."Profile";
require_once('bootstrap.php');


$templateParams["foglio-di-stile"] = "css/pages/info.css";

$templateParams["title"] = "Study Break";

$templateParams["main-content"] = 'personal_info_main.php';

$profileParams["user"] = $dbh->get_user_info($_SESSION['username']);



require '../utilities/templates/base.php';
?>