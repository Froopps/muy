<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    if(!(isset($_POST['voto'])&&isset($_POST['relativoA'])&&isset($_SESSION['email']))||$error_connection['flag'])
        goto error;

    $exists="SELECT * FROM valutazione WHERE utente='".escape($_SESSION['email'],$connected_db)."' AND relativoA='".$_POST['relativoA']."'";
    $exists=$connected_db->query($exists);
    if(!$exists)
        goto error;
    if(!$exists->fetch_row())
        $query="INSERT INTO valutazione(relativoA,voto,utente) VALUES('".$_POST['relativoA']."','".$_POST['voto']."','".$_SESSION['email']."')";
    else
        $query="UPDATE valutazione SET voto='".$_POST['voto']."' WHERE relativoA='".$_POST['relativoA']."' AND utente ='".$_SESSION['email']."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;  
    }
    echo "{\"error\":false}";
    exit();
    error:
        echo "{\"error\":true}";
?>