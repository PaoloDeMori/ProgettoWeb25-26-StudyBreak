<?php 
require_once('../bootstrap.php');


$input = json_decode(file_get_contents('php://input'), true);
if(isset($input['itemId'],$input['like'],$_SESSION['idUtenteLogged'])){
    if($input['like']){
        if($favouritesDbh->put_favourites_articles($_SESSION['idUtenteLogged'],$input['itemId'])){
            echo json_encode(['success' => true]);
        }else{
            echo json_encode(['success' => false]);
            exit();
        }
    }
    else{
            echo json_encode(['success' => false]);
            exit();
    }
}?>