<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../../../public/bootstrap.php');

if(isset($_POST['idbevanda'],$_POST['size'],$_POST['sugar'],$_POST['quantity'])){
    $latte=false;
    if(isset($_POST['milk'])){
        $latte=true;
    }
    if($cartDbh->move_bevanda_to_cart($_POST['idbevanda'],$_SESSION['idUtenteLogged'],$_POST['quantity'],
    $_POST['sugar'],$_POST['size'],$latte)){
       header("Location: ../../../../public/user/cart.php");
        exit;
    }
}
else{
     die("problema sconosciuto");
}
?>