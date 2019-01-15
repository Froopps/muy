<html>
    <head>
    <title>TEST</title>
    </head>
<body>
<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    
    $image = imagecreatefromstring(file_get_contents("1.0.PNG"));
        $size = min($x=imagesx($image),$y=imagesy($image));
        #riaglia un quadrato al centro dell'immagine
        if($size<164){
            $size=164;
            if($x==$y)
                $image2 = imagecrop($image,["x"=>0,"y"=>0,"width"=>$size,"height"=>$size]);
            else if($x>$y){
                $image2 = imagecrop($image,["x"=>($x-$y)/2,"y"=>0,"width"=>$size,"height"=>$size]);
                #$image2 = imagecrop($image,["x"=>($x-$y)/2,"y"=>($y-$size)/2 ,"width"=>$size,"height"=>$size]);
                echo "si";
            }else
                $image2 = imagecrop($image,["x"=>0,"y"=>($y-$x)/2,"width"=>$size,"height"=>$size]);
        }else{
            if($x==$y)
                $image2 = imagecrop($image,["x"=>0,"y"=>0,"width"=>$size,"height"=>$size]);
            else if($x>$y)
                $image2 = imagecrop($image,["x"=>($x-$y)/2,"y"=>0,"width"=>$size,"height"=>$size]);
            else
                $image2 = imagecrop($image,["x"=>0,"y"=>($y-$x)/2,"width"=>$size,"height"=>$size]);
        }
        imagepng($image2,"test.jpg");
        imagedestroy($image);
        imagedestroy($image2);
    
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
