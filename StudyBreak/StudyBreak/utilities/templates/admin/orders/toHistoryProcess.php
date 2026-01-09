<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../../../public/bootstrap.php');

if(isset($_GET['idordine'])){
    if($adminDbh->complete_order($_GET['idordine'])){
       header("Location: ../../../../public/admin/order_on_going.php");
        exit;
    }
}
else{
     die("problema sconosciuto");
}
?>