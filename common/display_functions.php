<?php
    include_once "functions.php";
    function user_info($info){
        echo "<table class='user_info'><tr>";
        $pub=get_visible_list($info["visibilita"]);
        #change in /default/logo.jpg
        #can't link by url something outside webroot directory for security constraints. So we need to embedd
        #the URI urlencoding file_get_contents() return value
        $pro_pic=$_SERVER["DOCUMENT_ROOT"]."/../muy_res";
        $pro_pic_alt="Spiacenti foto non trovata";
        if(!file_exists($pro_pic."/".$info["foto"]))
            log_into("Can't find profile pic at ".$pro_pic."/".$info["foto"]);
        $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($pro_pic."/".$info["foto"]));
        echo "<td rowspan='2'><a href='#user'><img class='propic' id='top-propic' src=$pro_pic alt=$pro_pic_alt></a></td>";
        echo "<td class='info'><a class='utente' href='#user'><h1>".$info["nickname"]."</h1></a></td>";
        echo "</tr><tr><td class='info'><ul>";
        foreach($pub as $key){
            echo "<li>".htmlentities(stripslashes($info[$key]))."</li>";
        }
        echo "</ul></td></tr></table>";
    }

    function channel_content_list($channel){
        
    }
?>