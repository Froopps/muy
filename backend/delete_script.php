<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $url="canale=".urlencode($_GET["canale"]); 
    $redirect_with_error="Location: http://localhost/muy/frontend/channel_mod.php?".htmlentities($url)."&error=";
    $redirect_with_msg="Location: http://localhost/muy/frontend/channel_mod.php?".htmlentities($url)."&msg=".urlencode("Oggetto eliminato con successo");
    $canale=$_GET["canale"];

    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        header($redirect_with_error);
        exit();
    }
    $query="SELECT proprietario FROM `oggettomultimediale` WHERE percorso='".$_GET["oggetto"]."'";
    $res=$connected_db->query($query);
    if(!$res){
        $connected_db->close();
        exit();
    }
    $row=$res->fetch_assoc();
    #controllo se altro utente sta cercando di eliminare
    if(!isset($_SESSION["email"])){
        $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=".urlencode("Accesso negato");
        header($redirect_with_error);
        exit();
    }
    if($row["proprietario"]!=$_SESSION["email"]){
        $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=".urlencode("Accesso negato");
        header($redirect_with_error);
        exit();
    }

    if(isset($_GET["oggetto"])){
        $query="DELETE FROM `oggettomultimediale` WHERE percorso='".$GET["oggetto"]."'";
        $res=$connected_db->query($query);
        if(!$res){
            $connected_db->close();
            exit();
        }
        $query="DELETE FROM `contenutotaggato` WHERE percorso='".$GET["oggetto"]."'";
        $res=$connected_db->query($query);
        if(!$res){
            $connected_db->close();
            exit();
        }
        $row=$res->fetch_assoc();

        header($redirect_with_msg);
        $connected_db->close();
        exit();
    }

    error:
        header($redirect_with_error);
        $connected_db->close();
        exit();
?>