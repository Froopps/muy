<html>
    <head>
    <title>TEST</title>
    </head>
<body>
<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $a=12345;
    echo substr($a,0,2).substr($a,3);
    
    echo "<br>";
    
    $a=null;
    if(isset($a))
        echo "yes";
    else
        echo "no";
    
    echo "<br>";
    
    $a=",,,1,,,,,2,3,,,";
    while($a[0]==",")
        $a=substr($a,1);
    while($a[strlen($a)-1]==",")
        $a=substr($a,0,-1);
    $a=preg_replace('/,+/', ',', $a);
    echo $a;
    
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
    display_tag_mosaic("#cani",$connected_db);
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
