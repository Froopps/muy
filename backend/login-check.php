<?php
    session_start();
    print_r($_POST);
    if($_POST["login"]=="Froopps" && $_POST['pwd']=="abc"){
        $_SESSION["logged"]=true;
        header("Location:../frontend/home.php");
    }else{
        $_SESSION["logged"]=false;
        header("Location:../frontend/login.php");
    }
?>