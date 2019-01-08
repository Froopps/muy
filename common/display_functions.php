<?php
    include_once "functions.php";
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    function display_user_info($info){
        $written_key=array("dataNascita"=>"compleanno","citta"=>"città");
        echo "<table class='user_info'><tr>";
        $pub=get_visible_list($info["visibilita"]);
        #change in /default/logo.jpg
        #can't link by url something outside webroot directory for security constraints. So we need to embedd
        #the URI urlencoding file_get_contents() return value
        $pro_pic=$_SERVER["DOCUMENT_ROOT"]."/../muy_res";
        $pro_pic_alt="Spiacenti foto non trovata";
        if(!file_exists($pro_pic."/".$info["foto"]))
            log_into("Can't find profile pic at ".$pro_pic."/".$info["foto"]);
            
        $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($pro_pic."/".stripslashes($info["foto"])));
        echo "<td rowspan='2'><a href='#user'><img class='propic' src=$pro_pic alt=$pro_pic_alt></a></td>";

        echo "<td class='info'><a class='utente' href='#user'><h1>".$info["nickname"]."</h1></a></td>";
        echo "</tr><tr><td class='info'><ul>";
        foreach($pub as $key){
            if(isset($written_key[$key]))
                echo "<li>".toUpperFirst($written_key[$key]).": ".$info[$key]."</li>";
            else
                echo "<li>".toUpperFirst($key).": ".$info[$key]."</li>";
        }
        echo "</ul></td></tr></table>";
    }

    function channel_content_list($channel){

    }

    function display_multimedia_object($info,$connected_db){
        $path=$_SERVER["DOCUMENT_ROOT"]."/../muy_res";
        echo "<span class=\"obj_multimedia\">";
        #leva if e lascia solo else
        if($info["anteprima"]=="defaults/obj_logo.jpg"||$info["anteprima"]=="anteprima_yt")
            $cover="data:image/png;base64,".base64_encode(file_get_contents("../sources/images/cover.png"));
        else
            $cover="data:image/png;base64,".base64_encode(file_get_contents($path.$info["anteprima"]));
        echo "<a class=\"oggetto\" href=\"#link\"><img class=\"imgobj\" src=\"".$cover."\" alt=\"cover\"></a>";
        echo "<div class=\"ohidden\"><a class=\"oggetto-titolo\" href=\"#link\">".$info["titolo"]."</a></div>";
        $res=get_user_by_email($info["proprietario"],$connected_db);
        /*
        if(!$res){
            $redirect_with_error.="Errore nella connessione con il database";
            log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
            header($redirect_with_error);
            $connected_db->close();
            exit();
        }
        */
        $row=$res->fetch_assoc();
        echo "<div class=\"ohidden\"><a class=\"oggetto-canale\" href=\"user.php?user=".htmlentities(urlencode(stripslashes($info["proprietario"])))."\">".$row["nickname"]."</a></div>";
        echo "<div class=\"ohidden\"><a class=\"oggetto-canale\" href=\"#channel\">".$info["canale"]."</a></div>";
        echo "<h3>Visual: ".$info["visualizzazioni"]."</h3>";
        echo "<h3 class=\"rate\">".valutazione($info["percorso"],$connected_db)."</h3>";
        echo "</span>";
    }
?>