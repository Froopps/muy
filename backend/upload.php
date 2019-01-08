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
    if(empty($_POST["MAX_FILE_SIZE"])||empty($_POST["channel"])||empty($_POST["title"])||empty($_POST["tag"])||empty($_POST["type"])||empty($_FILES["file"])){
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
    if(file_exists($path)){
        $redirect_with_error.=urlencode("Il file esiste già, rinominalo prima di caricarlo");
        goto error;
    }
    $query_values.="'".escape($path,$connected_db)."',";
    $query_columns.="percorso,";
    #anteprima
    $path_anteprima=$dir."/anteprima_".$_FILES["file"]["name"]."_".$_FILES["anteprima"]["name"];
    if($_FILES["anteprima"]["error"]==0){
        $query_values.="'".escape($path_anteprima,$connected_db)."',";
        $query_columns.="anteprima,";
    }
    if($_FILES["anteprima"]["error"]>0&&$_FILES["anteprima"]["error"]!=4){
        #4 è il caso default
        #notificare che l'anteprima non è stata caricata correttamente ma l'upload non viene bloccato
        #serve controllo che $_FILES["anteprima"]["type"] sia immagine
    }
    #titolo
    if(!preg_match('/^[A-Za-z0-9\'èéàòùì!? ]+$/',$_POST["title"])){
        $redirect_with_error.=urlencode("Titolo non accettabile");
        goto error;
    }
    #spazi inizio
    while($_POST["title"][0]==" "){
        $_POST["title"]=substr($_POST["title"],1);
    }
    #spazi fine
    while(substr($_POST["title"],-1)==" "){
        $_POST["title"]=substr($_POST["title"],0,-1);
    }
    $query_values.="'".escape($_POST["title"],$connected_db)."',";
    $query_columns.="titolo,";
    #descrizione
    if(!empty($_POST["desc"])){
        if(!preg_match('/^[A-Za-z0-9\'èéàòùì!? ]+$/',$_POST["desc"])){
            $redirect_with_error.=urlencode("Descrizione non accettabile");
            goto error;
        }
        if(strlen($_POST["desc"])>pow(2,24)-1){
            $redirect_with_error.=urlencode("Descrizione troppo lunga");
            goto error;
        }
    #spazi inizio
    while($_POST["desc"][0]==" "){
        $_POST["desc"]=substr($_POST["desc"],1);
    }
    #spazi fine
    while(substr($_POST["desc"],-1)==" "){
        $_POST["desc"]=substr($_POST["desc"],0,-1);
    }
    $query_values.="'".escape($_POST["desc"],$connected_db)."',";
    $query_columns.="descrizione,";
    }
    #tipo
    #checking anyone sending post without the signup form
    if(!empty($_POST["type"])){
        if(!($_POST["type"]=="v"||$_POST["type"]=="a"||$_POST["type"]=="i")){
            #servono confronti tra $_POST["type"] e $_FILES["file"]["type"]
            $redirect_with_error.=urlencode("Tipo di file non valido");
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
    $query_values.="'".escape($_POST["channel"],$connected_db)."',";
    $query_columns.="canale,";
    echo $_POST["channel"];
    #proprietario
    #controllo se mail è valida?
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
    echo $dir."<br";
    echo $path."<br";
    echo $path_anteprima;

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
            $query="INSERT INTO contenutotaggato (tag,oggetto) VALUES ('#".escape($tag,$connected_db)."','".escape($path,$connected_db)."')";
            $res=$connected_db->query($query);
            if(!$res){
                $redirect_with_error.=urlencode("Errore nella connessione con il database 4");
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