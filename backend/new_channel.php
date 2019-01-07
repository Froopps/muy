<?php
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    #checking error in connection
    $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=";
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        header($redirect_with_error);
        exit();
    }
    $query_columns="";
    $query_values="";
    $count=0;
    if(!(isset($_POST["channel_name"]) && isset($_POST["owner"]))){
        $redirect_with_error.="Inserire tutti i dati necessari";
        goto error;
    }
    $query="SELECT COUNT(*) FROM canale WHERE nome='".$_POST["channel_name"]."' and proprietario='".$_POST["owner"]."'";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.="Errore nella connessione con il database ";
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }
    $row=$res->fetch_row();
    if($row[0]>0){
        $redirect_with_error.="Hai già un canale con questo nome";
        goto error;
    }
    $query_columns.="proprietario,nome";
    $query_values.="'".escape($_POST["owner"],$connected_db)."','".escape($_POST["channel_name"],$connected_db)."'";

    if(!in_array($_POST["channel_type"],array("public","social","private"))){
        $redirect_with_error.="Esèrimere un valore di visibilità sensato";
        goto error;
    }

    $query_columns.=",visibilita";
    $query_values.=",'".$_POST["channel_type"]."'";

    if(isset($_POST["label"])){
        $query_columns.=",etichetta";
        $query_values.=",'".escape($_POST["label"],$connected_db)."'";
    }

    $query_columns.=",dataCreazione";
    $query_values.=",'".date('Y-m-d',time())."'";

    $query="INSERT INTO canale (".$query_columns.") VALUES (".$query_values.")";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.="Errore nella connessione con il database ";
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }
    
    header("Location: http://localhost/muy");
    $connected_db->close();
    exit();

    error:
        header($redirect_with_error);
        $connected_db->close();
        exit();
?>