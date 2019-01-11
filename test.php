<html>
    <head>
    <title>TEST</title>
    </head>
<body>
    <script>
        var a=""
        if(a=="")
            alert("si")
        else
            alert("no")
    </script>
    
    
    <br>
<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    
    echo substr("video/.mp4",0,6);
    echo "<br>";
    $a=null;
    if(isset($a))
        echo "yes";
    else
        echo "no";
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
