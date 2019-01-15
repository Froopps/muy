<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    /*
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    header("Content-type: text/xml; charset=utf-8");
    */

    $value="";
    $path=$_SERVER["DOCUMENT_ROOT"]."/../muy_res".$_POST["path"];

    if($error_connection["flag"]){
        $value=$error_connection["msg"];
        exit();
    }

    #controllo se altro utente sta cercando di eliminare
    $query="SELECT proprietario FROM `oggettomultimediale` WHERE percorso='".escape($_POST["path"],$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        $connected_db->close();
        goto error;
    }
    $row=$res->fetch_assoc();
    if(!isset($_SESSION["email"])||$row["proprietario"]!=$_SESSION["email"]){
        $value="Accesso negato";
        goto error;
    }

    #delete content
    $query="DELETE FROM `oggettomultimediale` WHERE percorso='".escape($_POST["path"],$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        $connected_db->close();
        exit();
    }
    unlink($path);
    unlink($path."/../anteprima.png");
    rmdir($path."/../");

    #delete in contenutotaggato is on cascade so nothing here

    #check and delete unassigned tags
    $query="DELETE FROM `categoria` WHERE tag NOT IN (SELECT tag FROM contenutotaggato)";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        $connected_db->close();
        exit();
    }
        
    echo "<error triggered='false'><message></message></error>";
    exit();

    error:
        echo "<error triggered='true'><message>".$value."</message></error>";
?>