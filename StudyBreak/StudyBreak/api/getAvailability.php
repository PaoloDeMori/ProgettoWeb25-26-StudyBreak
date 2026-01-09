<?php
require_once __DIR__ . '/../../public/bootstrap.php';

header('Content-Type: application/json');

$id = $_GET['ID_bevanda'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID mancante"]);
    exit;
}

$availability = $dbh->get_item_from_id($id);
if ($availability === null) {
    echo json_encode(["success" => false, "message" => "Articolo non trovato"]);
    exit;
}

echo json_encode([
    "success" => true,
    "disponibilita" => (int)$availability->disponibilita
]);
