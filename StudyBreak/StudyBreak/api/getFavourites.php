<?php
require_once __DIR__ . '/../public/bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['idUtenteLogged'])) {
    echo json_encode([]);
    exit;
}

$idUser = $_SESSION['idUtenteLogged'];

$favourites = $favouritesDbh->get_favourites_articles($idUser);
echo json_encode($favourites);
?>