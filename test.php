<html>
    <head>
    <title>TEST</title>
    </head>
<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
        $query="SELECT * FROM `categoria` WHERE tag='#cani'";
        $res=$connected_db->query($query);
        if(!$res){
            $connected_db->close();
            exit();
        }
        $row=$res->fetch_assoc();
        if(empty($row)){
            echo "yes";
        }
        $connected_db->close();
?>
</html>
