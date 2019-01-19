<?php
include_once "functions.php";

function get_user_by_email($mail,$connected_db){
    $query="SELECT *,COUNT(*) FROM utente WHERE email='".escape($mail,$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_channel_by_owner($mail,$connected_db){
    $query="SELECT * FROM canale WHERE proprietario='".escape($mail,$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_relationship($subject,$object,$connected_db){
    $query="SELECT stato,COUNT(*) FROM amicizia WHERE sender='".escape($subject,$connected_db)."' AND receiver='".escape($object,$connected_db)."' OR sender='".escape($object,$connected_db)."' AND receiver='".escape($subject,$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
        return $res;
    }
    $row=$res->fetch_assoc();
    if($row['COUNT(*)']<=0)
        return 'no';
    else if(!$row['stato'])
        return 'pending';
    else
        return $row['stato'];

}

function get_pending_request($mail,$offset,$connected_db){
    $offset=4*$offset;
    $query="SELECT  email,foto,nickname FROM utente JOIN amicizia ON email=sender WHERE receiver='".escape($mail,$connected_db)."' AND stato IS NULL LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;

}

function get_friends($mail,$offset,$connected_db){
    $offset=4*$offset;
    $query="SELECT  email,foto,nickname FROM utente JOIN amicizia ON sender=email WHERE receiver='".escape($mail,$connected_db)."' AND stato='a' UNION SELECT email,foto,nickname FROM utente JOIN amicizia ON receiver=email WHERE sender='".escape($mail,$connected_db)."' AND stato='a'LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;

}

function get_suggestions_by_city($mail,$offset,$connected_db){
    $offset=4*$offset;
    $query="SELECT t.email AS email,t.foto AS foto,t.nickname AS nickname FROM utente t JOIN utente AS r on t.citta=r.citta WHERE t.email!='".escape($mail,$connected_db)."' AND r.email='".escape($mail,$connected_db)."' AND t.email NOT IN (SELECT email FROM utente JOIN amicizia ON sender=email WHERE receiver='".escape($mail,$connected_db)."' UNION SELECT email FROM utente JOIN amicizia ON receiver=email WHERE sender='".escape($mail,$connected_db)."')LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_content_by_id($id,$connected_db){
    $query="SELECT * FROM oggettoMultimediale WHERE extID='$id'";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_content_tag($path,$connected_db){
    $query="SELECT tag FROM contenutotaggato WHERE oggetto='".escape($path,$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_search_suggestion($table,$pattern,$connected_db){
    $mapping=array("utente"=>"nickname","oggettoMultimediale"=>"titolo","canale"=>"nome","categoria"=>"tag");
    $query="SELECT ".$mapping[$table]." FROM $table WHERE ".$mapping[$table]." LIKE '$pattern%' ORDER BY ".$mapping[$table]." LIMIT 6 OFFSET 0";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_search_result($table,$pattern,$connected_db,$offset){
    $offset=$offset*8;
    $mapping=array("utente"=>"nickname","oggettoMultimediale"=>"titolo","canale"=>"nome","categoria"=>"tag");
    $query="SELECT * FROM $table WHERE ".$mapping[$table]."='$pattern' UNION SELECT * FROM $table WHERE ".$mapping[$table]." LIKE '%$pattern%' LIMIT 8 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}
?>