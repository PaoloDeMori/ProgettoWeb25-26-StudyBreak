<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($mainPagesParams["main"])){
    require($mainPagesParams["main"]);
    }
if(isset($mainPagesParams["footer"])){
    require($mainPagesParams["footer"]);
    }
?>