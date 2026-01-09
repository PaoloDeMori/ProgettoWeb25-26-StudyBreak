<?php
require_once __DIR__ . '/../public/bootstrap.php';
header('Content-Type: application/json');

$articoli = $dbh->get_most_ordered_articles(null, null, $_SESSION['caffe'], $_SESSION['only-not-available']);
echo json_encode($articoli);
?>