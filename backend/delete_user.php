<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    $redirect_with_error="Location: http://localhost/muy/frontend/user.php?user=".urlencode($_SESSION['email'])."&error=";
    $error="Errore nella connessione con il server";

    if(!isset($_SESSION['email'])||$error_connection['flag'])
        goto error;
    $query="SELECT COUNT(*) FROM amicizia WHERE (sender='".escape($_SESSION['email'],$connected_db)."' OR receiver='".escape($_SESSION['email'],$connected_db)."') AND (stato IS NULL OR stato='a')";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
        goto error;
    }
    $row=$res->fetch_row();
    if($row[0]!=0){
        #echo $row[0];
        $error="Per eliminarti è necessario che tu non abbia richieste di amicizia pendenti nè alcuna amicizia corrente";
        goto error;
    }
    $query="DELETE FROM amicizia WHERE sender='".escape($_SESSION['email'],$connected_db)."' OR receiver='".$_SESSION['email']."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
        goto error;
    }
    
    $query="DELETE FROM utente WHERE email='".escape($_SESSION['email'],$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
        goto error;
    }
    $utente=$_SESSION["nome"];
    session_destroy();
    header("Location:../frontend/home.php?msg=Addio, ".$utente);
    exit();

    error:
        $redirect_with_error.=urlencode($error);
        header($redirect_with_error);
        exit();
?>