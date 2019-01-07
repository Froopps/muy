<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/upload.php?error=";
    $redirect_with_msg="Location: http://localhost/muy/frontend/home.php?msg=Upload_avvenuto_con_successo";
    $query_columns="";
    $query_values="";
    #exit() is used after redirect to avoid further statements execution after redirecting with error
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        goto error;
    }
    #checking anyone sending post without the signup form. We need all the required data
    if(empty($_POST["MAX_FILE_SIZE"])||empty($_POST["channel"])||empty($_POST["title"])||empty($_POST["tag"])||empty($_POST["type"])||empty($_FILES["file"])){
        $redirect_with_error.="Invia tutti i dati richiesti";
        goto error;
    }
    #input file error check
    if($_FILES["file"]["error"]>0){
        $redirect_with_error.="Errore di upload: error ".$_FILES["file"]["error"];
        goto error;
    }
    #percorso
    $path=$_SERVER["DOCUMENT_ROOT"]."/../muy_res/content/".$_SESSION["email"]."/".str_replace(" ","_",$_POST["channel"]);
    mkdir($path."/".str_replace(" ","_",$_FILES["file"]["name"]),0770);
    $path_anteprima=$path."/".str_replace(" ","_",$_FILES["file"]["name"]);
    $path.="/".str_replace(" ","_",$_FILES["file"]["name"])."/".str_replace(" ","_",$_FILES["file"]["name"]);
    if(file_exists($path)){
        $redirect_with_error.="Il file esiste già, rinominalo prima di caricarlo";
        goto error;
    }
    $query_values.="'".$path."',";
    $query_columns.="percorso,";
    #anteprima
    if($_FILES["anteprima"]["error"]==0){
        $path_anteprima.="/anteprima_".$_FILES["file"]["name"]."_".$_FILES["anteprima"]["name"];
        $query_values.="'".$path_anteprima."',";
        $query_columns.="anteprima,";
    }
    if($_FILES["anteprima"]["error"]>0&&$_FILES["anteprima"]["error"]!=4){
        #4 è il caso default
        #notificare che l'anteprima non è stata caricata correttamente ma l'upload non viene bloccato
        #serve controllo che $_FILES["anteprima"]["type"] sia immagine
    }
    #titolo
    if(!preg_match('/^[A-Za-z0-9\'èéàòù!? ]+$/',$_POST["title"])){
        $redirect_with_error.="Titolo non accettabile";
        goto error;
    }
    $query_values.="'".escape($_POST["title"],$connected_db)."',";
    $query_columns.="titolo,";
    #descrizione
    if(!empty($_POST["desc"])){
        if(!preg_match('/^[A-Za-z0-9\'èéàòù!? ]+$/',$_POST["desc"])){
            $redirect_with_error.="Descrizione non accettabile";
            goto error;
        }
        if(strlen($_POST["desc"])>pow(2,24)-1){
            $redirect_with_error.="Descrizione troppo lunga";
            goto error;
        }
    $query_values.="'".escape($_POST["desc"],$connected_db)."',";
    $query_columns.="descrizione,";
    }
    #tipo
    #checking anyone sending post without the signup form
    if(!empty($_POST["type"])){
        if(!($_POST["type"]=="v"||$_POST["type"]=="a"||$_POST["type"]=="i")){
            #servono confronti tra $_POST["type"] e $_FILES["file"]["type"]
            $redirect_with_error.="Tipo di file non valido";
            goto error;
        }
        $query_values.="'".$_POST["type"]."',";
        $query_columns.="tipo,";
    }
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
    #move files
    move_uploaded_file($_FILES["file"]["tmp_name"],$path);
    if($_FILES["anteprima"]["error"]==0){
        move_uploaded_file($_FILES["anteprima"]["tmp_name"],$path_anteprima);
    }

    #etichette
    if(isset($_POST["tag"])){
        if($_POST["tag"][0]=="#"){
            $_POST["tag"]=substr($_POST["tag"],1);
        }
        $tags=explode("#",$_POST["tag"]);
        foreach($tags as $tag){
            #spazi inizio
            while($tag[0]==" "){
                $tag=substr($tag,1);
            }
            #spazi fine
            while(substr($tag,-1)==" "){
                $tag=substr($tag,0,-1);
            }
            #doppi spazi
            $tag=preg_replace('/\s+/', ' ',$tag);
            
            $query="SELECT * FROM `categoria` WHERE tag='#".$tag."'";
            $res=$connected_db->query($query);
            if(!$res){
                $redirect_with_error.="Errore nella connessione con il database ";
                log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                goto error;
            }
            $row=$res->fetch_assoc();
            if(empty($row)){
                $query="INSERT INTO categoria (tag) VALUES ('#".$tag."')";
                $res=$connected_db->query($query);
                if(!$res){
                    $redirect_with_error.="Errore nella connessione con il database ";
                    log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                    goto error;
                }
            }
            $query="INSERT INTO contenutotaggato (tag,oggetto) VALUES ('#".$tag."','".$path."')";
            $res=$connected_db->query($query);
            if(!$res){
                $redirect_with_error.="Errore nella connessione con il database ";
                log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                goto error;
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