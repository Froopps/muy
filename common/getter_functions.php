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
    $query="SELECT stato,COUNT(*) FROM amicizia WHERE sender='$subject' AND receiver='$object' OR sender='$object' AND receiver='$subject'";
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
    $query="SELECT  email,foto,nickname FROM utente JOIN amicizia ON email=sender WHERE receiver='$mail' AND stato IS NULL LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;

}

function get_friends($mail,$offset,$connected_db){
    $offset=4*$offset;
    $query="SELECT  email,foto,nickname FROM utente JOIN amicizia ON sender=email WHERE receiver='$mail' AND stato='a' UNION SELECT email,foto,nickname FROM utente JOIN amicizia ON receiver=email WHERE sender='$mail' AND stato='a'LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;

}

function get_suggestions_by_city($mail,$offset,$connected_db){
    $offset=4*$offset;
    $query="SELECT t.email AS email,t.foto AS foto,t.nickname AS nickname FROM utente t JOIN utente AS r on t.citta=r.citta WHERE t.email!='$mail' AND r.email='$mail' AND t.email NOT IN (SELECT email FROM utente JOIN amicizia ON sender=email WHERE receiver='$mail' UNION SELECT email FROM utente JOIN amicizia ON receiver=email WHERE sender='$mail')LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_content_by_id($id,$connected_db){
    $query="SELECT percorso FROM oggettoMultimediale WHERE extID='$id'";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}
?>