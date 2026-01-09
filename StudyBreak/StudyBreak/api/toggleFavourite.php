<?php
require_once __DIR__ . '/../public/bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['idUtenteLogged'])) {
    echo json_encode(["success" => false, "debug" => [
            "session" => $_SESSION,
            "post" => $_POST
        ]]);
    exit;
}

$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

if (!$data || !isset($data['id_bevanda'], $data['liked'])) {
    echo json_encode([
        "success" => false,
        "error" => "Invalid input data",
        "debug" => ["raw_input" => file_get_contents("php://input")]
    ]);
    exit;
}

$idUser = $_SESSION['idUtenteLogged'];
$id_bevanda = $data['id_bevanda'];
$liked = $data['liked'];

if ($liked) {
    $result = $favouritesDbh->put_favourites_articles($idUser, $id_bevanda);
} else {
    $result = $favouritesDbh->remove_favourites_articles($idUser, $id_bevanda);
}

echo json_encode(["success" => $result]);
?>