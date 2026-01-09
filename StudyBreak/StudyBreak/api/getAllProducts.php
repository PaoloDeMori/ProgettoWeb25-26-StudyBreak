<?php
require_once __DIR__ . '/../public/bootstrap.php';
header('Content-Type: application/json');

$articoli = $adminDbh->get_bevande();
echo json_encode($articoli);
?>