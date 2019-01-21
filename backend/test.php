<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    echo "<?xml version='1.0' encoding='UTF-8'?>";
    header("Content-type: text/xml; charset=utf-8");
    $error="Errore nella connessione con il server";

    if(!isset($_SESSION['email'])||$error_connection['flag'])
        goto error;
    $query="SELECT COUNT(*) FROM amicizia WHERE (sender='".$_SESSION['email']."' OR receiver='".$_SESSION['email']."') AND stato!='p' AND stato!='r'";
    $res=$connected_db->query($query);
    if(!$res)
        goto error;
    $row=$res->fetch_row();
    if($row[0]!=0){
        $error="Per eliminarti è necessario che tu non abbia richieste di amicizia pendenti nè alcuna amicizia corrente";
        goto error;
    }

    $query="DELETE FROM amicizia WHERE sender='".$_SESSION['email']."' OR receiver='".$_SESSION['email']."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
        goto error;
    }
    
    $query="DELETE FROM utente WHERE email='".$_SESSION['email']."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
        goto error;
    }

    echo "<error triggered='false'><message></message></error>";
    exit();

    error:
        echo "<error triggered='true'><message>$error</message></error>";
        $connected_db->close();
        exit();

?>