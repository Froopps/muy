<html>
    <head>
    <title>TEST</title>
    </head>
<body>
<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    
    $a="èdsoa'h'yha";
    echo escape($a,$connected_db);
        
    echo "<br>";

    $query="SELECT voto FROM valutazione WHERE voto='2'";
    $res=$connected_db->query($query);
    if(!$res){
        $connected_db->close();
        exit();
    }
    $row=$res->fetch_assoc();
    print_r($res);
    if(empty($row)){
        echo "yws";
    }
    
    echo "<br>";
    
    $query="SELECT * FROM `oggettomultimediale` WHERE tipo='a'";
    $res=$connected_db->query($query);
    if(!$res){
        $connected_db->close();
        exit();
    }
    while($row=$res->fetch_assoc()){
        display_multimedia_object($row,$connected_db);
    }
    $connected_db->close();
?>
</body>
</html>
