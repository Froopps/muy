<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/upload.php?error=";
    $redirect_with_msg="Location: http://localhost/muy/frontend/home.php?msg=".urlencode("Upload avvenuto con successo");
    $query_columns="";
    $query_values="";
    #exit() is used after redirect to avoid further statements execution after redirecting with error
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        goto error;
    }
    #checking anyone sending post without the signup form. We need all the required data
    if(empty($_POST["url"])){
        $redirect_with_error.=urlencode("Inserisci un url");
        #$redirect_with_error.="Invia tutti i dati richiesti";
        goto error;
    }
    #controllo url youtube valido
    #spazi inizio
    while($_POST["url"][0]==" "){
        $tag=substr($_POST["url"],1);
    }
    #spazi fine
    while(substr($_POST["url"],-1)==" "){
        $_POST["url"]=substr($_POST["url"],0,-1);
    }
    $query_values.="'".escape($_POST["url"],$connected_db)."',";
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
    $query_values.="'".escape($_POST["channel"],$connected_db)."',";
    $query_columns.="canale,";
    #proprietario
    #controllo se mail è valida?
    $query_values.="'".escape($_SESSION["email"],$connected_db)."'";
    $query_columns.="proprietario";

    $query="INSERT INTO oggettomultimediale (".$query_columns.") VALUES (".$query_values.")";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }

    #etichette

    header($redirect_with_msg);
    $connected_db->close();
    exit();
    error:
        header($redirect_with_error);
        $connected_db->close();
        exit();
?>