<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    #avoid http proxy intrusion and any other homemad request
    $valid_attributes=array('email','passwd','nome','cognome','nickname','sesso','citta');
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    header("Content-type: text/xml; charset=utf-8");

    if($error_connection["flag"]){
        $value=$error_connection["msg"];
        goto error;
    }

    if(!in_array($_POST['attribute'],$valid_attributes)){
        $value="L'aggiornamento può essere fatto solo su valori validi";
        goto error;
    }

    switch($_POST["attribute"]){
        case 'email':
            $res=valid_new_email($_POST['value'],$connected_db);
            $value=($res['error']) ? $res["msg"] : 1;
            break;
        case 'passwd':
            $value=(strlen($_POST['value'])<8) ? 'La password deve essere di almeno otto caratteri' : 1;
            break;
        case 'sesso':
            $value=!($_POST['value']=='Maschio'||$_POST['value']=='Femmina') ? 'Stringa non valida' : 1;
            break;
        case 'nickname':
            $_POST['value']=$_POST['value']=="" ? "User" : $_POST['value'];
            $value=1;
            break;
        case 'citta':
            $value=!(norm_pattern($_POST['value'])||$_POST['value']=="") ? 'Stringa non valida' :1;
            break;
        default:
            $value=!(norm_pattern($_POST['value'])) ? 'Stringa non valida' : 1;
            break;
    }

    if($value==1){
        $query="UPDATE utente SET ".$_POST["attribute"]."='".escape($_POST["value"],$connected_db)."' WHERE email='".$_SESSION["email"]."'";
        $res=$connected_db->query($query);
        $connected_db->close();
    }

    else goto error;

    if($res==NULL){
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        $value="Errore nella connessione con il database";
        goto error;
    }
    if($_POST['attribute']=='email') $_SESSION['email']=$_POST['value'];

    echo "<error triggered='false'><message></message></error>";
    exit();
    
    error:
        echo "<error triggered='true'><message>".$value."</message></error>";

    function norm_pattern($str){
        return preg_match('/^[A-Za-z\'èéàòù ]+$/',$str);
    }

?>