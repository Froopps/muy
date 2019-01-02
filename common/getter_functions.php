<?php
function get_user_by_email($mail,$connected_db){
    $query="SELECT * FROM utente WHERE email='".$mail;
    $query.="'";
    $res=$connected_db->query($query);
    return $res;
}

function get_channel_by_owner($mail,$connected_db){
    $query="SELECT * FROM canale WHERE proprietario='".$mail."'";
    $res=$connected_db->query($query);
    return $res;
}
?>