<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../public/bootstrap.php');

if(isset($_POST['username'],$_POST['password'],$_POST['email'],$_POST['confirm'])){
    if(register($_POST['username'],$_POST['password'],$_POST['email'],$_POST['confirm'])){
        header("Location: ../../public/user/homepage.php");
        $_SESSION['register_status']='success';
    }else{
        $_SESSION['register_status']='failed';
        header("Location: ../../public/signup.php");
        exit();
    }
}
else{
    $_SESSION['register_status']='failed';
    header("Location: ../../public/signup.php");
    exit();
}

?>