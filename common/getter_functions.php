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
    $query="SELECT * FROM canale WHERE proprietario='".escape($mail,$connected_db)."' ORDER BY dataUltimoInserimento DESC";
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
    $query="SELECT tag FROM contenutoTaggato WHERE oggetto='".escape($path,$connected_db)."' ORDER BY dataAssegnamento ASC";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

#LE SEGUENTI TRE QUERY SONO UTILIZZATE SIA PER MOSTRARE I RISULTATI DELLA RICERCA CHE PER ELEBORARE I SUGGERIMENTI
#per ottenere risultati dalla ricerca di utente e categoria che sono sempre pubblici
function get_public_result($table,$pattern,$connected_db,$offset,$limit=3,$suggestion=false){
    #per categoria e utente non c'è bisogno di verificare nessuna relzione di amicizia
    $offset=$offset*3;
    $mapping=array("utente"=>"nickname","categoria"=>"tag");
    #mostra prima le tuple che hanno valore completamente uguale al pattern per quell'attributo, poi quelle che iniziano
    $query="SELECT * FROM $table WHERE ".$mapping[$table]."='$pattern' UNION ";
    $query2="SELECT * FROM $table WHERE ".$mapping[$table]." LIKE '$pattern%' ORDER BY ".$mapping[$table];
    $limit=" LIMIT $limit OFFSET $offset";
    if($suggestion)
        $res=$connected_db->query($query2.$limit);
    else
        $res=$connected_db->query($query.$query2.$limit);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_searched_channel($who,$pattern,$connected_db,$offset,$limit=3,$suggestion=false){
    #per contenuto e canale c'è bisogno di verificare nessuna relzione di amicizia
    #subject sarebbe il richiedente
    $offset=$offset*3;
    #query per prelevare tutti gli amici dell'utente che ricerca
    $friends="SELECT  email FROM utente JOIN amicizia ON sender=email WHERE receiver='".escape($who,$connected_db)."' AND stato='a' UNION SELECT email FROM utente JOIN amicizia ON receiver=email WHERE sender='".escape($who,$connected_db)."' AND stato='a'";
    #se il nome corrisponde al pattern e se il canale è pubblico, social+richiedente amico del proprietario, o proprietario stesso
    $query="SELECT foto,proprietario,canale.nome AS nome FROM canale JOIN utente ON proprietario=email WHERE canale.nome='$pattern' AND (canale.visibilita='public' OR proprietario='$who' OR (canale.visibilita='social' AND proprietario IN ($friends))) UNION ";
    $query2="SELECT foto,email,canale.nome AS nome FROM canale JOIN utente ON proprietario=email WHERE canale.nome LIKE '$pattern%' AND (canale.visibilita='public' OR proprietario='$who' OR (canale.visibilita='social' AND proprietario IN ($friends))) ORDER BY nome";
    $limit=" LIMIT $limit OFFSET $offset";
    if($suggestion)
        $res=$connected_db->query($query2.$limit);
    else
        $res=$connected_db->query($query.$query2.$limit);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_searched_content($who,$pattern,$connected_db,$offset,$limit=3,$suggestion=false){
    $offset=$offset*3;
    $friends="SELECT  email FROM utente JOIN amicizia ON sender=email WHERE receiver='".escape($who,$connected_db)."' AND stato='a' UNION SELECT email FROM utente JOIN amicizia ON receiver=email WHERE sender='".escape($who,$connected_db)."' AND stato='a'";
    $query="SELECT extID,anteprima,titolo,tipo FROM oggettoMultimediale JOIN canale ON canale.proprietario=oggettoMultimediale.proprietario AND canale.nome=oggettoMultimediale.canale WHERE titolo='$pattern' AND (canale.visibilita='public' OR canale.proprietario='$who' OR (canale.visibilita='social' AND canale.proprietario IN ($friends))) UNION ";
    $query2="SELECT extID,anteprima,titolo,tipo FROM oggettoMultimediale JOIN canale ON canale.proprietario=oggettoMultimediale.proprietario AND canale.nome=oggettoMultimediale.canale WHERE titolo LIKE '$pattern%' AND (canale.visibilita='public' OR canale.proprietario='$who' OR (canale.visibilita='social' AND canale.proprietario IN ($friends))) ORDER BY titolo";
    $limit=" LIMIT $limit OFFSET $offset";
    if($suggestion)
        $res=$connected_db->query($query2.$limit);
    else
        $res=$connected_db->query($query.$query2.$limit);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

#query per reperire i contenuti caricati dai propri amici nella giornata corrente
function get_today_friends_content($who,$connected_db,$offset){
    $offset=$offset*3;
    $today=date('Y-m-d',time());
    $friends="SELECT  email FROM utente JOIN amicizia ON sender=email WHERE receiver='".escape($who,$connected_db)."' AND stato='a' UNION SELECT email FROM utente JOIN amicizia ON receiver=email WHERE sender='".escape($who,$connected_db)."' AND stato='a'";
    $query="SELECT * FROM oggettoMultimediale JOIN canale ON canale.nome=oggettoMultimediale.canale AND canale.proprietario=oggettoMultimediale.proprietario WHERE canale.proprietario IN($friends) AND dataCaricamento LIKE '$today%' LIMIT 3 OFFSET $offset";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_most_visited($type,$connected_db){
    $query="SELECT * FROM oggettoMultimediale WHERE tipo='$type' ORDER BY visualizzazioni DESC LIMIT 10 OFFSET 0";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    return $res;
}

function get_channel_visibility($channel,$user,$connected_db){
    $query="SELECT visibilita FROM canale WHERE nome='$channel' AND proprietario='$user'";
    $res=$connected_db->query($query);
    if(!$res)
        log_into("Errore nell'esecuzione della query ".$query." ".$connected_db->error);
    $row=$res->fetch_assoc();
    return $row["visibilita"];
}
?>