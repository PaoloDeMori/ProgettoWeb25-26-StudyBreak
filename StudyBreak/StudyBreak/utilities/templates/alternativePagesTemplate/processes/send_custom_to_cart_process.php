<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../../../public/bootstrap.php');
if (isset($_POST['id_custom_to_cart'], $_SESSION['idUtenteLogged'])) {
    $id_bevanda = $_POST['id_custom_to_cart'];
    $id_utente = $_SESSION['idUtenteLogged'];
    if ($cartDbh->move_bevanda_custom_to_cart($id_bevanda, $id_utente)) {
        header("Location: ../../../../public/user/cart.php");
        exit;
    } else {
        $templateParams['error-in-show-custom-product'] = "Problem while adding item to cart";
    }
}
?>