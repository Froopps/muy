<html>
    <head>
    <title>TEST</title>
    </head>
<body>
    
    <button id="init">INIT</button>
    <button id="destroy">DESTROY</button>
    <div id="demo"></div>
    <br>
    <script>
        let instance;
        
        alert(document.getElementById("destroy"))
        document.getElementById('destroy').onclick = () => {
            if (!instance) return;
            instance.destroy();
          instance = null;
        };

        document.getElementById('init').onclick = () => {
            if (instance) return;

          instance = new Croppie(document.getElementById('demo'), {
                url: 'http://foliotek.github.io/Croppie/demo/demo-2.jpg'
            });
        };
    </script>
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
