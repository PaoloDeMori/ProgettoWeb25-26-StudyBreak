<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../public/bootstrapNotAuthenticate.php');

if(isset($_POST['username'],$_POST['password'])){
    if(login($_POST['username'],$_POST['password'])){
        if(isset($_SESSION['role'])){
            if($_SESSION['role']===CLIENTE_ROLE_VALUE){
                $_SESSION['login_status']='success';
                header("Location: ../../public/user/homepage.php");
            }
            elseif($_SESSION['role']===VENDITORE_ROLE_VALUE){
                $_SESSION['login_status']='success';
                header("Location: ../../public/admin/homepage.php");
                exit();
            }
            else{
                die('Il ruolo settato nella sessione non è valido');
            }
        }
        else{
            die('Il ruolo settato nella sessione non è valido');
        }
    }else{
        $_SESSION['login_status']='failed';
        header("Location: ../../public/login.php");
        exit();
    }
}
else{
     $_SESSION['login_status']='failed';
     header("Location: ../../public/login.php");
     exit();
}

?>