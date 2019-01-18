<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $valid=array('utente');
    if(!(isset($_GET['table'])&&isset($_GET['pattern'])&&in_array($_GET['table'],$valid)))
        exit();
    $res=get_search_suggestion($_GET['table'],$_GET['pattern'],$connected_db);
    if(!$res||$res->num_rows==0)
        echo "Nessun suggerimento";
    else{
        echo "<ul calss='sug_list'>";
        while($row=$res->fetch_row())
            echo "<li>".$row[0]."</li>";
        echo "</ul>";
    }
 
?>