<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/upload.php?error=";
    $query_columns="";
    $query_values="";
    #exit() is used after redirect to avoid further statements execution after redirecting with error
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        goto error;
    }
    #checking anyone sending post without the signup form. We need all the required data
    if(empty($_POST["url"])){
        $redirect_with_error.="Inserisci un url";
        #$redirect_with_error.="Invia tutti i dati richiesti";
        goto error;
    }
    #controllo url youtube valido
    $query_values.="'".$_POST["url"]."',";
    $query_columns.="percorso,";
    #anteprima
    $query_values.="'anteprima_yt',";
    $query_columns.="anteprima,";
    #titolo
    $query_values.="'titolo_yt',";
    $query_columns.="titolo,";
    #descrizione
    $query_values.="'descrizione_yt',";
    $query_columns.="descrizione,";
    #tipo
    $query_values.="'v',";
    $query_columns.="tipo,";
    #dataCaricamento
    $query_values.="'".date('Y-m-d H:i:s')."',";
    $query_columns.="dataCaricamento,";
    #canale
    #controllo canale valido per checking anyone sending post without the signup form?
    $query_values.="'".$_POST["channel"]."',";
    $query_columns.="canale,";
    #proprietario
    #controllo se mail è valida?
    $query_values.="'".$_SESSION["email"]."'";
    $query_columns.="proprietario";

    $query="INSERT INTO oggettomultimediale (".$query_columns.") VALUES (".$query_values.")";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.="Errore nella connessione con il database ";
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }

    #etichette

    header("Location: http://localhost/muy");
    $connected_db->close();
    exit();
    error:
        header($redirect_with_error);
        $connected_db->close();
        exit();
?>