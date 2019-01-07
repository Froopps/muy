<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/channel_mod.php?canale=".$_GET["canale"]."&error=";
    $redirect_with_msg="Location: http://localhost/muy/frontend/channel_mod.php?canale=".$_GET["canale"]."&msg=Oggetto_eliminato_con_successo";
    $canale=str_replace("_"," ",$_GET["canale"]);

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
    if($row["proprietario"]!=$_SESSION["email"]){
        $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=Accesso_negato";
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