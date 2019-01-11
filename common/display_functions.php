<?php
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    function display_user_info($info,$connected_db){
        $written_key=array("dataNascita"=>"compleanno","citta"=>"città");
        echo "<table class='user_info'><tr>";
        $pub=get_visible_list($info["visibilita"]);
        #change in /default/logo.jpg
        #can't link by url something outside webroot directory for security constraints. So we need to embedd
        #the URI urlencoding file_get_contents() return value
        $pro_pic=$_SERVER["DOCUMENT_ROOT"]."/../muy_res";
        $pro_pic_alt="-No image-";
        if(!file_exists($pro_pic."/".$info["foto"]))
            log_into("Can't find profile pic at ".$pro_pic."/".$info["foto"]);

        $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($pro_pic."/".stripslashes($info["foto"])));

        echo "<td class='pic_and_but' rowspan='2'><a href='#user'><img class='propic' src=$pro_pic alt=$pro_pic_alt></a><div>";
        if(isset($_SESSION["email"])&&$_SESSION["email"]!=$info["email"]){
            $status=get_relationship($_SESSION["email"],$info["email"],$connected_db);
            if(!$status){
                echo "<span class='error_span'>Errore nella connessione al server</span></div></td></tr></table>";
                exit();
            }
            echo "<button class='in_notext' type='button' ";
            switch($status){
                case 'a':
                    echo "disabled>Amico";
                    break;
                #restituito da get_relationship in caso di nessuna relazione ne presente ne passata
                case "no":
                    echo "onclick=\"request_fr(this,'".$info['email']."')\">Invia richiesta";
                    break;
                case 'pending':
                    echo "disabled>In attesa di conferma";
                    break;
                default:
                    echo "style='background-color: #837d7d' disabled>Bloccato";
                    break;


            }
            
            echo "</button></div></td>";
        }
        
        echo "<td class='info'><a class='utente' href='#user'><h1>".$info["nickname"]."</h1></a></td>";
        echo "</tr><tr><td class='info'><ul>";
        foreach($pub as $key){
            if(isset($written_key[$key])){
                if(isset($info[$key]))
                    echo "<li>".toUpperFirst($written_key[$key]).": ".$info[$key]."</li>";
            }else
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
        if($info["anteprima"]=="anteprima_yt")
            $cover="data:image/png;base64,".base64_encode(file_get_contents("../sources/images/cover.png"));
        else
            $cover="data:image/png;base64,".base64_encode(file_get_contents($path.$info["anteprima"]));
        echo "<a class=\"oggetto\" href=\"#link\"><img class=\"imgobj\" src=\"".$cover."\" alt=\"cover\"></a>";
        echo "<div class=\"ohidden\"><a class=\"oggetto-titolo\" href=\"#link\">".$info["titolo"]."</a></div>";
        $res=get_user_by_email($info["proprietario"],$connected_db);
        
        if(!$res){
            $redirect_with_error.="Errore nella connessione con il database";
            header($redirect_with_error);
            $connected_db->close();
            exit();
        }
        $row=$res->fetch_assoc();
        echo "<div class=\"ohidden\"><a class=\"oggetto-canale\" href=\"user.php?user=".htmlentities(urlencode(stripslashes($info["proprietario"])))."\">".$row["nickname"]."</a></div>";
        echo "<div class=\"ohidden\"><a class=\"oggetto-canale\" href=\"#channel\">".$info["canale"]."</a></div>";
        echo "<h3>Visual: ".$info["visualizzazioni"]."</h3>";
        echo "<h3 class=\"rate\">".valutazione($info["percorso"],$connected_db)."</h3>";
        echo "</span>";
    }

    function display_friendslist_rows($res,$next,$action,$connected_db){
        $no_more=false;
        $count=0;
        for($j=0;$j<2&&!$no_more;$j++){
            echo "<div class='friend_list_row'>";
            for($i=0;$i<2;$i++){
                if($count>=count($res)){
                    $no_more=true;
                    break;
                }
                display_friendslist_entry($res[$count],$action);
                $count++;
            }
            echo "</div>";
        }
        if(!$no_more){
            #se possono esserci risultati successivi, inserisci nel DOM un elemento in cui inserirli tramite chiamata AJAX
            echo "<div class='four_more'></div>";
            #e un bottone 'altro' dal cui valore dipenderà l'offset con cui fare la query per mostrare altri risultati
            echo "<div class='error_div'><span><button class='in_notext show_more' style='background-color:#837d7d' value='$next' type='button' onclick=\"refresh_friendslist('$action',this)\">Altro</button></span></div>";
        }

    }

    function display_friendslist_entry($info,$action){
        $pro_pic=$_SERVER["DOCUMENT_ROOT"]."/../muy_res";
        $pro_pic_alt="Spiacenti foto non trovata";
        if(!file_exists($pro_pic."/".$info["foto"]))
            log_into("Can't find profile pic at ".$pro_pic."/".$info["foto"]);
        $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($pro_pic."/".stripslashes($info["foto"])));

        echo "<div class='friend_list_entry'>";
            echo "<div class='friend_list_entry_half'>";
                echo "<img class='pro_pic_in_list' src='$pro_pic' alt=$pro_pic_alt>";
            echo "</div>";
            echo "<div class='friend_list_entry_half'>";
                echo "<div><a href='http://localhost/muy/frontend/user.php?user=".urlencode($info['email'])."'><h4 class='nick_in_link'>".stripslashes($info['nickname'])."</h4></a></div>";
                echo "<div class='action_div'>";
                    if($action=='pending'){
                        echo "<button class='in_notext' type='button' onclick=\"up_status('accept','".$info['email']."',this)\">Conferma</button>";
                        echo "<button class='in_notext' style='background-color: #837d7d' type='button' onclick=\"up_status('deny','".$info['email']."',this)\">Rifiuta</button>";
                    }
                    if($action=='friends'){
                        echo "<button class='in_notext' style='background-color: #837d7d' type='button' onclick=\"up_status('erase','".$info['email']."',this)\">Elimina</button>";
                    }
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
?>