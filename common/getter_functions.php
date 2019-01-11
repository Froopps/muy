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
    $query="SELECT  * FROM amicizia WHERE receiver='".$mail."' AND stato is NULL LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;

}

function get_friends($mail,$offset,$connected_db){
    $offset=4*$offset;
    $query="SELECT  * FROM amicizia WHERE receiver='".$mail."' AND stato='a' OR sender='".$mail."' AND stato='a' LIMIT 4 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;

}

function get_suggestions_by_city($city,$offset,$connected_db){
    $offset=4*$offset;
}

?>