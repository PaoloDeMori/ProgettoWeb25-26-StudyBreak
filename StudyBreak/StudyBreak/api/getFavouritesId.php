<?php
require_once __DIR__ . '/../public/bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['idUtenteLogged'])) {
    echo json_encode([]);
    exit;
}

$idUser = $_SESSION['idUtenteLogged'];

$favourites = $favouritesDbh->get_favourites_articles($idUser);

$favIds = array_map(fn($bev) => $bev->id, $favourites);
echo json_encode($favIds);
?>