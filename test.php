<html>
    <head>
    <title>TEST</title>
    </head>
<body>
    <script>
        /*
        var video_id = window.location.search.split('v=')[1]
        var ampersandPosition = video_id.indexOf('&')
        if(ampersandPosition!=-1)
          video_id = video_id.substring(0, ampersandPosition)
          */
    </script>
<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    
    $id=getYoutubeId("https://www.youtube.com/watch?v=jNQXAC9IVRw");
    echo $thumbnail="http://img.youtube.com/vi/".$id."/hqdefault.jpg";
    $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($thumbnail));
    echo "<img class='propic' src=$pro_pic>";
    ritaglia($pro_pic,$_SERVER["DOCUMENT_ROOT"]."/../muy_res/thumbnail.jpg");

    
    
    
    
    function get_youtube($url){

        $youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";

        $curl = curl_init($youtube);
        url_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return json_decode($return, true);

    }

    $url = "https://www.youtube.com/watch?v=wIpkO_QSuHc";

    // Display Data 
    //print_r(get_youtube($url));
    
    
    
    
    
    echo "<br>";
        echo "Location:".$_SERVER["DOCUMENT_ROOT"]."/muy/frontend/home.php";
    echo "<br>";

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
