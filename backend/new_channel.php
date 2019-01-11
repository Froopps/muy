<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/user.php?user=".urlencode($_SESSION["email"])."&error=";
    $redirect_with_msg="Location: http://localhost/muy/frontend/user.php?user=".urlencode($_SESSION["email"])."&msg=".urlencode("Canale creato con successo");
    #checking error in connection
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        header($redirect_with_error);
        exit();
    }
    $query_columns="";
    $query_values="";
    $count=0;
    if(!(isset($_POST["channel_name"]) && isset($_POST["owner"]))){
        $redirect_with_error.=urlencode("Inserire tutti i dati necessari");
        goto error;
    }

    $query="SELECT COUNT(*) FROM canale WHERE nome='".escape($_POST["channel_name"],$connected_db)."' and proprietario='".escape($_POST["owner"],$connected_db)."'";

    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }
    $row=$res->fetch_row();
    if($row[0]>0){
        $redirect_with_error.=urlencode("Hai già un canale con questo nome");
        goto error;
    }
    if(strlen($_POST["channel_name"])>200){
        $redirect_with_error.=urlencode("Nome canale troppo lungo");
        goto error;
    }
    $query_columns.="proprietario,nome";
    $query_values.="'".escape($_POST["owner"],$connected_db)."','".escape($_POST["channel_name"],$connected_db)."'";

    if(!in_array($_POST["channel_type"],array("public","social","private"))){
        $redirect_with_error.=urlencode("Esprimere un valore di visibilità sensato");
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
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }
    mkdir($_SERVER["DOCUMENT_ROOT"]."/../muy_res/content/".$_POST["owner"]."/".$_POST["channel_name"],0770);
    header($redirect_with_msg);

    $connected_db->close();
    exit();

    error:
        header($redirect_with_error);
        $connected_db->close();
        exit();
?>