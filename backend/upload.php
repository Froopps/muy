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
    if(empty($_POST["MAX_FILE_SIZE"])||empty($_POST["channel"])||empty($_POST["title"])||empty($_FILES["file"])){
        $redirect_with_error.=urlencode("Invia tutti i dati richiesti");
        goto error;
    }
    #input file error check
    if($_FILES["file"]["error"]>0){
        $redirect_with_error.=urlencode("Errore di upload: error: ".htmlentities(urlencode($_FILES["file"]["error"])));
        goto error;
    }
    #percorso
    $dir="/content/".$_SESSION["email"]."/".$_POST["channel"]."/".$_FILES["file"]["name"];
    $path=$dir."/".$_FILES["file"]["name"];
    $path_anteprima=$dir."/anteprima";
    if(strlen($path>600)){
        $redirect_with_error.=urlencode("Nome file troppo lungo");
        goto error;
    }
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/../muy_res".$path)){
        $redirect_with_error.=urlencode("Il file esiste già, rinominalo prima di caricarlo");
        goto error;
    }
    $query_values.="'".escape($path,$connected_db)."',";
    $query_columns.="percorso,";
    #anteprima
    #controlli sul tipo, anteprima dipenderà da essi
    #checking anyone sending post without the signup form
    if(!(substr($_FILES["file"]["type"],0,6)=="audio/"||substr($_FILES["file"]["type"],0,6)=="video/"||substr($_FILES["file"]["type"],0,6)=="image/")){
            $redirect_with_error.=urlencode("Il tipo di file non è supportato");
            goto error;
    }
    switch (substr($_FILES["file"]["type"],0,6)){   #serve?
        case "audio/":
            break;
        case "video/":
            break;
        case "image/":
            break;
    }
    if($_FILES["anteprima"]["error"]==0&&substr($_FILES["anteprima"]["type"],0,6)=="image/"){
        $query_values.="'".escape($path_anteprima,$connected_db)."',";
        $query_columns.="anteprima,";
    }
    if($_FILES["anteprima"]["error"]>0&&$_FILES["anteprima"]["error"]!=4){
        #4 è il caso default
        #notificare che l'anteprima non è stata caricata correttamente ma l'upload non viene bloccato
        #serve controllo che $_FILES["anteprima"]["type"] sia immagine
    }
    #titolo
    trimSpaceBorder($_POST["title"]);
    if(!preg_match('/^[A-Za-z0-9\'èéàòùì!? ]+$/',$_POST["title"])){
        $redirect_with_error.=urlencode("Titolo non accettabile");
        goto error;
    }
    if(strlen($_POST["title"]>200)){
        $redirect_with_error.=urlencode("Titolo troppo lungo");
        goto error;
    }
    $query_values.="'".escape($_POST["title"],$connected_db)."',";
    $query_columns.="titolo,";
    #descrizione
    if(!empty($_POST["desc"])){
        trimSpaceBorder($_POST["desc"]);
        if(!preg_match('/^[A-Za-z0-9\'èéàòùì!? ]+$/',$_POST["desc"])){
            $redirect_with_error.=urlencode("Descrizione non accettabile");
            goto error;
        }
        if(strlen($_POST["desc"])>pow(2,24)-1){
            $redirect_with_error.=urlencode("Descrizione troppo lunga");
            goto error;
        }
    $query_values.="'".escape($_POST["desc"],$connected_db)."',";
    $query_columns.="descrizione,";
    }
    #tipo
    switch (substr($_FILES["file"]["type"],0,6)) {
        case "audio/":
            $query_values.="'a',";
            break;
        case "video/":
            $query_values.="'v',";
            break;
        case "image/":
            $query_values.="'i',";
            break;
    }
    $query_columns.="tipo,";
    #dataCaricamento
    $query_values.="'".date('Y-m-d H:i:s')."',";
    $query_columns.="dataCaricamento,";
    #canale
    #controllo canale valido per checking anyone sending post without the signup form?
    $query_values.="'".escape($_POST["channel"],$connected_db)."',";
    $query_columns.="canale,";
    #proprietario
    $query_values.="'".escape($_SESSION["email"],$connected_db)."'";
    $query_columns.="proprietario";

    $query="INSERT INTO oggettomultimediale (".$query_columns.") VALUES (".$query_values.")";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.=urlencode("Errore nella connessione con il database 1");
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }
    #move files
    mkdir($_SERVER["DOCUMENT_ROOT"]."/../muy_res".$dir,0770);
    move_uploaded_file($_FILES["file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/../muy_res".$path);
    if($_FILES["anteprima"]["error"]==0)
        move_uploaded_file($_FILES["anteprima"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/../muy_res".$path_anteprima);

    #etichette
    if(!(empty($_POST["tag"]))){
        if($_POST["tag"][0]=="#"){
            $_POST["tag"]=substr($_POST["tag"],1);
        }
        $tags=explode("#",$_POST["tag"]);
        foreach($tags as $tag){
            if(!($tag=="")){
                trimSpace($tag);
                $tag=strtolower($tag);

                $query="SELECT * FROM `categoria` WHERE tag='#".escape($tag,$connected_db)."'";
                $res=$connected_db->query($query);
                if(!$res){
                    $redirect_with_error.=urlencode("Errore nella connessione con il database 2");
                    log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                    goto error;
                }
                $row=$res->fetch_assoc();
                if(empty($row)){
                    $query="INSERT INTO categoria (tag) VALUES ('#".escape($tag,$connected_db)."')";
                    $res=$connected_db->query($query);
                    if(!$res){
                        $redirect_with_error.=urlencode("Errore nella connessione con il database 3");
                        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                        goto error;
                    }
                }
                $query="INSERT INTO contenutotaggato (tag,oggetto,dataAssegnamento) VALUES ('#".escape($tag,$connected_db)."','".escape($path,$connected_db)."','".date('Y-m-d H:i:s')."')";
                $res=$connected_db->query($query);
                if(!$res){
                    $redirect_with_error.=urlencode("Errore nella connessione con il database 4");
                    log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                    goto error;
                }
            }
        }
    }
    header($redirect_with_msg);
    $connected_db->close();
    exit();

    error:
        header($redirect_with_error);
        $connected_db->close();
        exit();
?>