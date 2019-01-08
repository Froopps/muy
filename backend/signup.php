<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/signup.php?error=";
    $query_columns="";
    $query_values="";
    #exit() is used after redirect to avoid further statements execution after redirecting with error
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        goto error;
    }
    #checking anyone sending post without the signup form. We need all the required data
    if(empty($_POST["mail"])|| empty($_POST["pwd"])||empty($_POST["pwd-c"])||empty($_POST["nom"])||empty($_POST["cog"])||empty($_POST["dataNa"])){
        $redirect_with_error.=urlencode("Invia tutti i dati richiesti");
        goto error;
    }
    #mail check
    $resm=valid_new_email($_POST["mail"],$connected_db);
    if($resm["error"]){
        $redirect_with_error.=urlencode($resm["msg"]);
        goto error;
    }
    $query_values.="'".$resm["result"]."',";
    $query_columns.="email,";
    #pwd check
    if(strlen($_POST["pwd"])<8){
        $redirect_with_error.=urlencode("La password deve essere di almeno 8 caratteri");
        goto error;
    }
    if($_POST["pwd"]!=$_POST["pwd-c"]){
        $redirect_with_error.=urlencode("Conferma password sbagliata");
        goto error;
    }
    $query_values.="'".blowhash($_POST["pwd"])."',";
    $query_columns.="passwd,";
    #name check
    if(!preg_match('/^[A-Za-z\'èéàòù ]+$/',$_POST["nom"])){
        $redirect_with_error.=urlencode("Inserire un nome vero");
        goto error;
    }
    $query_values.="'".escape($_POST["nom"],$connected_db)."',";
    $query_columns.="nome,";
    #lastname check
    if(!preg_match('/^[A-Za-z\'èéàòù ]+$/',$_POST["cog"])){
        $redirect_with_error.=urlencode("Inserire un cognome vero");
        goto error;
    }
    $query_values.="'".escape($_POST["cog"],$connected_db)."',";
    $query_columns.="cognome,";
    #checking anyone sending post without the signup form
    $birthday=strtotime($_POST["dataNa"]);
    if(!$birthday){
        $redirect_with_error.=urlencode("Inserire una data valida");
        goto error;
    }
    $birthday=date('Y-m-d',$birthday);
    if($birthday>date('Y-m-d',time())||$birthday<'1900-01-01'){
        $redirect_with_error.=urlencode("Inserire una data valida");
        goto error;
    }
    $query_values.="'".$birthday."',";
    $query_columns.="dataNascita,";
    #nickname check
    if(!empty($_POST["nick"])){
        $query_values.="'".escape($_POST["nick"],$connected_db)."',";
        $query_columns.="nickname,";
    }
    #checking anyone sending post without the signup form
    if(!empty($_POST["sex"])){
        if(!($_POST["sex"]=="Femmina"||$_POST["sex"]=="Maschio")){
            $redirect_with_error.=urlencode("Il sesso può essere maschio o femmina");
            goto error;
        }
        $query_values.="'".$_POST["sex"]."',";
        $query_columns.="sesso,";
    }
    #city check
    if(!empty($_POST["cit"])){
        if(!preg_match('/^[A-Za-zèéàòù ]+$/',$_POST["cit"])){
            $redirect_with_error.=urlencode("Inserire un nome di città valido");
            goto error;     
        }
        $query_values.="'".escape($_POST["cit"],$connected_db)."',";
        $query_columns.="citta,";
    }
    if(empty($_POST["check_list"])){
        $query_values.="0";
        $query_columns.="visibilita";
    }
    else{
        $query_values.="'".set_visibility($_POST["check_list"])."'";
        $query_columns.="visibilita";
    }
    #checking profile pic finire sta roba

    $query="INSERT INTO utente (".$query_columns.") VALUES (".$query_values.")";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }
    $new_user_dir=$_SERVER["DOCUMENT_ROOT"]."/../muy_res/content/".$_POST["mail"];
    mkdir($new_user_dir,0770);
    mkdir($new_user_dir."/pro_pic",0770);

    $_SESSION["email"]=stripslashes($resm["result"]);
    $_SESSION["nome"]=$_POST["nick"];
    $_SESSION["foto"]="defaults/default-profile-pic.png";   #temporaneo
    #just for developement test, in login-check.php too

    if($_POST["sex"]=="Femmina")
        $redirect_with_msg="Location: http://localhost/muy/frontend/home.php?msg=".urlencode("Sei registrata, ".$_SESSION["nome"]."! Benvenuta su myUNIMIyoutube");
    if($_POST["sex"]=="Maschio")
        $redirect_with_msg="Location: http://localhost/muy/frontend/home.php?msg=".urlencode("Sei registrato, ".$_SESSION["nome"]."! Benvenuto su myUNIMIyoutube");

    header($redirect_with_msg);
    $connected_db->close();
    exit();
    
    error:
        session_destroy();
        header($redirect_with_error);
        $connected_db->close();
        exit();
?>