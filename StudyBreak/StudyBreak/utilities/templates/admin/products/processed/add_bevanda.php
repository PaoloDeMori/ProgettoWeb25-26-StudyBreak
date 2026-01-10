<?php
require_once('../../../../../public/bootstrap.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: homepage.php");
    exit;
}

$nome = trim($_POST["productName"] ?? "");
$prezzo = (float) ($_POST["productPrice"] ?? 0);
$disponibilita = (int) ($_POST["productAvailability"] ?? 0);
$idVenditore = 1;

if ($nome === "" || $prezzo <= 0 || $disponibilita <= 0) {
    die("Invalid data");
}

$foto = null;

if (!empty($_FILES["productPicture"]["name"])) {
    $uploadDir = __DIR__ . '/../../../../../img/'; 
    
    $fileTmp = $_FILES["productPicture"]["tmp_name"];
    $fileName = uniqid() . "_" . basename($_FILES["productPicture"]["name"]);
    
    $fullPath = $uploadDir . $fileName;

    $mime = mime_content_type($fileTmp);
    if (!in_array($mime, ["image/jpeg", "image/png"])) {
        die("Invalid image type");
    }

    if (move_uploaded_file($fileTmp, $fullPath)) {
        $foto = $fileName;
    } else {
        error_log("Errore caricamento. Percorso tentato: " . $fullPath);
        die("Errore critico: Impossibile spostare il file. Verifica i permessi della cartella " . $uploadDir);
    }
}
$bevanda = new BevandaDTO(
    null,
    $nome,
    $prezzo,
    $foto,
    0,
    $disponibilita
);

$success = $adminDbh->insertBevanda($bevanda, $idVenditore);

if ($success) {
    header("Location: ../../../../../public/admin/homepage.php?success=1");
} else {
    die("Error saving product");
}

?>