<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/upload.php?error=";
    $redirect_with_msg="Location: http://localhost/muy/frontend/user.php?user=".urlencode($_SESSION["email"])."&msg=".urlencode("Upload youtube avvenuto con successo");
    $query_columns="";
    $query_values="";
    #exit() is used after redirect to avoid further statements execution after redirecting with error
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        goto error;
    }

    if(empty($_POST["url"])||empty($_POST["channel"])||empty($_POST["title"])){
        $redirect_with_error.=urlencode("Inserisci tutti i dati richiesti");
        goto error;
    }
    $result=explode("www.youtu",$_POST["url"]);
    if(!isset($result[1])){
        $redirect_with_error.=urlencode("URL non valido");
        goto error;
    }
    $_POST["url"]=trimSpaceBorder($_POST["url"]);

    $dir="/content/".$_SESSION["email"]."/".$_POST["channel"]."/".$_POST["url"];
    $id=getYoutubeId($_POST["url"]);
    $thumbnail="http://img.youtube.com/vi/".$id."/hqdefault.jpg";
    $immagine="data:image/png;base64,".base64_encode(file_get_contents($thumbnail));

    #percorso
    $query="SELECT percorso FROM oggettoMultimediale WHERE canale='".escape($_POST["channel"],$connected_db)."' AND proprietario='".escape($_SESSION["email"],$connected_db)."' AND percorso='".escape($_POST["url"],$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        goto error;
    }
    if($res->num_rows>0){
        $redirect_with_error.=urlencode("Hai già questo video sul canale");
        goto error;
    }
    $query_values.="'".escape($_POST["url"],$connected_db)."',";
    $query_columns.="percorso,";
    #anteprima
    $query_values.="'".escape($dir,$connected_db)."/anteprima.png',";
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

    $query="INSERT INTO oggettoMultimediale (".$query_columns.") VALUES (".$query_values.")";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        goto error;
    }

    echo $_SERVER["DOCUMENT_ROOT"]."/../muy_res".$dir;
    mkdir($_SERVER["DOCUMENT_ROOT"]."/../muy_res".$dir,0770);
    ritaglia($immagine,$_SERVER["DOCUMENT_ROOT"]."/../muy_res".$dir."/anteprima.png");

    #etichette

    //header($redirect_with_msg);
    $connected_db->close();
    exit();
    error:
        //header($redirect_with_error);
        $connected_db->close();
        exit();
?>