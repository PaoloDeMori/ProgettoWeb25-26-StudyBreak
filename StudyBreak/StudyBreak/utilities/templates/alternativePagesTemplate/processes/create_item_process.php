<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../../../public/bootstrap.php');

if(isset($_SESSION['idUtenteLogged'],$_POST['custom-item-name'])){
    if(!isset($_POST['ingredienti']) || empty($_POST['ingredienti'])) {
        $_SESSION['error-creation-phrase'] = "Devi selezionare almeno un ingrediente!";
        header("Location: ../../../../public/user/create.php");
        exit();
    }
    $id_user=$_SESSION['idUtenteLogged'];
    $beverage_name=$_POST['custom-item-name'];
    $ingredients=$_POST['ingredienti'];
    $_SESSION['error-creation-phrase']=null;

    $customs_from_name=$dbh->get_custom_from_name($beverage_name,$id_user);
    if(empty($customs_from_name)){
        if($dbh->create_CustomBeverage($id_user, $beverage_name,$ingredients)){
                header("Location: ../../../../public/user/homepage.php");
                exit();
            }
            else{
                $_SESSION['error-creation-phrase']= "Error while creating the item";
                header("Location: ../../../../public/user/create.php");
                exit();
            }
        }else{
            $_SESSION['error-creation-phrase']= "A custom beverage with this name already exists";
            header("Location: ../../../../public/user/create.php");
            exit();
        }
    }
    else{
            $_SESSION['error-creation-phrase']= "Invalid fields";
            header("Location: ../../../../public/user/create.php");
            exit();
        }
?>