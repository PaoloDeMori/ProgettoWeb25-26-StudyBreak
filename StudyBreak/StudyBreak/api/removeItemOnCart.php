<?php
require_once __DIR__ . '/../public/bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['idUtenteLogged'])) {
    echo json_encode([
        "success" => false,
        "debug" => [
            "session" => $_SESSION,
            "post" => $_POST
        ]
    ]);
    exit;
}
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(["success" => false, "error" => "Invalid data"]);
    exit;
}

$idUser = $_SESSION['idUtenteLogged'];
$id = (int) $data['id'];
$isCustom = !empty($data['custom']);

if ($isCustom) {
    $result = $cartDbh->remove_bevanda_custom_by_id($id, $idUser);
} else {
    $result = $cartDbh->remove_bevanda_by_bevanda_id($id, $idUser);
}

$cart = $cartDbh->getCart($idUser);
$totalPrice = $cart->totalPrice ?? 0;

echo json_encode([
    "success" => $result,
    "totalPrice" => $totalPrice
]);
?>