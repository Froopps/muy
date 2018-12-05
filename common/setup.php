<?php
    #if this file is included remember to check the error connection status
    $host="localhost";
    $user="root";
    $passwd="";
    $db="muy";
    $error_connection=array("flag"=>0,"msg"=>"");
    $connected_db=new mysqli($host,$user,$passwd,$db);
    if($connected_db->connect_errno){
        $error_connection["flag"]=1;
        $error_connection["msg"]="Errore nella connessione col database";
    }
?>