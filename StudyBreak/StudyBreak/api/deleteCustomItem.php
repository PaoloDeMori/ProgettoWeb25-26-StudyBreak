<?php
require_once __DIR__ . '/../public/bootstrap.php';
header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$idToDelete = $data['itemId'] ?? null;

$userId=$_SESSION['idUtenteLogged'];

$iSucceded=$dbh->delete_custom_from_id($idToDelete,$userId);
echo json_encode(["status" => $iSucceded ? "success" : "error"]);
?>