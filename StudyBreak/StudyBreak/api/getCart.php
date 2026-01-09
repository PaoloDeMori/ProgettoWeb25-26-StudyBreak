<?php
require_once __DIR__ . '/../public/bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['idUtenteLogged'])) {
    echo json_encode([]);
    exit;
}

$idUser = $_SESSION['idUtenteLogged'];

$cart = $cartDbh->getCart($idUser);

echo json_encode($cart);
?>