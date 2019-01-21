<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $res=get_content_by_id($_POST["id"],$connected_db);
    if(!$res||$res->num_rows!=1)
        exit();
    $path=$res->fetch_assoc()["percorso"];

    if($error_connection["flag"]){
        $value=$error_connection["msg"];
        exit();
    }

    #controllo se altro utente sta cercando di eliminare
    $query="SELECT proprietario FROM `oggettoMultimediale` WHERE percorso='".escape($path,$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        $connected_db->close();
        exit();
    }
    $row=$res->fetch_assoc();
    if($res->num_rows==0||!isset($_SESSION["email"])||$row["proprietario"]!=$_SESSION["email"]){
        #accesso negato
        exit();
}
    #delete content
    $query="DELETE FROM `oggettoMultimediale` WHERE percorso='".escape($path,$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        $connected_db->close();
        exit();
    }
    $path=$_SERVER["DOCUMENT_ROOT"]."/../muy_res".$path;
    unlink($path);
    unlink($path."/../anteprima.png");
    rmdir($path."/../");

    #delete in contenutotaggato is on cascade so nothing here

    #check and delete unassigned tags
    $query="DELETE FROM `categoria` WHERE tag NOT IN (SELECT tag FROM contenutoTaggato)";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        $connected_db->close();
        exit();
    }
?>