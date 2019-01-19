<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $valid=array('utente','oggettoMultimediale','canale','categoria');
    if(!(isset($_GET['table'])&&isset($_GET['pattern'])&&in_array($_GET['table'],$valid)))
        exit();
    $res=get_search_suggestion($_GET['table'],$_GET['pattern'],$connected_db);
    if(!$res||$res->num_rows==0)
        echo "<li class='entry_sug'>Nessun suggerimento</li>";
    else{
        while($row=$res->fetch_row())
            echo "<li class='entry_sug' onclick=\"autocomp(this.innerHTML)\" onclick=\"suggestion_search()\">".$row[0]."</li>";
    }
 
?>