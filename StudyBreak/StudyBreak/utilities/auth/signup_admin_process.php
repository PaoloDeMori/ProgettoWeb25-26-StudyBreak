<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../public/bootstrapNotAuthenticate.php');

if(isset($_POST['username'],$_POST['password'],$_POST['confirm'])){
    if(register_admin($_POST['username'],$_POST['password'],$_POST['confirm'])){
        header("Location: ../../public/admin/homepage.php");
        $_SESSION['register_status']='success';
    }else{
        $_SESSION['register_status']='failed';
        header("Location: ../../public/admin/sign_up_admin.php");
        exit();
    }
}
else{
    $_SESSION['register_status']='failed';
    header("Location: ../../public/admin/sign_up_admin.php");
    exit();
}

?>