<html>
    <head>
    <title>TEST</title>
    </head>
<body>
<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $a=null;
    if(isset($a))
        echo "yes";
    else
        echo "no";
    echo "<br>";
    echo "<br>";

    $pippo="";

    $query="SELECT * FROM `contenutotaggato`";
    $res=$connected_db->query($query);
    if(!$res){
        $connected_db->close();
        exit();
    }
    print_r($res);
    echo "<br>";
    echo "<br>";
    while($row=$res->fetch_assoc()){
        echo $pippo=$row["oggetto"];
        echo "<br>";
    }
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo $pippo;
    echo "<br>";
    
    $query="SELECT tag as cont FROM `contenutotaggato` WHERE tag='".escape($pippo,$connected_db)."'";
    $res=$connected_db->query($query);
    if(!$res){
        $connected_db->close();
        exit();
    }
    print_r($res);
    echo "<br>";
    echo "<br>";
    while($row=$res->fetch_assoc()){
        echo $row["cont"];
        echo "<br>";
    }
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
#   if(empty($row)){
#        echo "yws";
#    }
    
    $connected_db->close();
?>
</body>
    <script>
        if(Number.isInteger(5))
            alert("si")
    </script>
</html>
