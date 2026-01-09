<?php
require_once __DIR__ . '/../public/bootstrap.php';

header('Content-Type: application/json');

$q = $_GET['q'] ?? '';

$bevande = $dbh->searchByName($q);
echo json_encode($bevande);
?>