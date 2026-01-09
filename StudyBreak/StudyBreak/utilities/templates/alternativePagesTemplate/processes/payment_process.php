<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../../../public/bootstrap.php');

if(isset($_POST['card-number'],$_POST['card-holder'],$_POST['expiry-date'],$_POST['security-code'])){
    $mysqlData=formatExpiryDateForDB($_POST['expiry-date']);
    if($mysqlData===null){
        die("invalid data");
    }
    if($cartDbh->from_cart_to_order($_SESSION['idUtenteLogged'], $_POST['card-number'],$_POST['card-holder'],$mysqlData,$_POST['security-code'])){
        header("Location: ../../../../public/user/cart.php");
        exit;
    }
    }
else{
     die("problema sconosciuto");
}
?>