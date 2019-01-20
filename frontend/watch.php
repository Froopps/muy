<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: home.php?error=";
    if(isset($_GET["id"])){
        $res=get_content_by_id($_GET["id"],$connected_db);
        if(!$res||$res->num_rows!=1)
            header($redirect_with_error.urlencode("Errore nella visualizzazione del contenuto"));
        if($error_connection["flag"])
            header($redirect_with_error.urlencode("Errore nella visualizzazione del contenuto"));
        $row=$res->fetch_assoc();
    }else
        header($redirect_with_error.urlencode("Errore nella visualizzazione del contenuto"));
    #controllo se contenuto è dell'utente loggato
    $self=false;
    if(isset($_SESSION["email"])&&$_SESSION["email"]==$row["proprietario"])
        $self=true;
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | <?php echo $row["titolo"]; ?></title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>

    <?php 
        if(isset($_SESSION["email"])){
            include "../common/header_logged.php";
            include "../common/sidebar_logged.php";
        }else{
            include "../common/header_unlogged.php";
            include "../common/sidebar_unlogged.html";
        }
    ?>

        <main>
            <div class="content">
                <?php
                    if(isset($_GET["error"])){
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                    if(isset($_GET["msg"])){
                        echo "<span class='message_span'>".$_GET["msg"]."</span>";
                    }
                ?>

                <div class="show-obj">
                    <div class="show">
                        <?php
                            $file=explode("/",$row["percorso"]);
                            $ext=explode(".",$file[count($file)-1]);
                            $ext=$ext[count($ext)-1];
                        
                            $archive=$_SERVER["DOCUMENT_ROOT"]."/../muy_res".$row["percorso"];
                            $tempath=$_SERVER["DOCUMENT_ROOT"]."/muy/sources/tmp/".$file[4];

                            switch($row["tipo"]){
                                case "a":
                                    $file=$_SERVER["DOCUMENT_ROOT"]."\..\muy_res".$row["anteprima"];
                                    $image="data:image/png;base64,".base64_encode(file_get_contents($file));
                                    echo "<div class=\"audio-cover\"><img class=\"oggetto\" src=\"".$image."\" onclick=\"document.getElementById('modal_bg_img').style.display='flex'\"></div>";
                                    echo "<div class=\"audio-ctrl-bar\"><audio controls>";
                                    echo "<source src=\"horse.ogg\" type=\"audio/".$ext."\">Your browser does not support the audio element.</audio></div>";
                                    break;
                                case "v":
                                    $path=$_SERVER["DOCUMENT_ROOT"]."/muy/source/fake/".$row["percorso"];
                                    /*if(!file_exists($path))
                                        symlink($archive,$tempath);*/
                                    #copy($archive,$tempath);
                                    #rename($_SERVER["DOCUMENT_ROOT"]."\..\muy_res".$row["percorso"],$_SERVER["DOCUMENT_ROOT"]."\muy");
                                    #symlink($_SERVER["DOCUMENT_ROOT"]."\..\muy_res".$row["percorso"],$_SERVER["DOCUMENT_ROOT"]."\..\muy_res");
                                    echo "<video controls>";
                                    echo "<source src=\"../sources/tmp/".$file[4]."\" type=\"video/".$ext."\">Your browser does not support HTML5 video.</video>";
                                    #unlink($_SERVER["DOCUMENT_ROOT"]."/muy/sources/tmp/".$file[4]);
                                    break;
                                case "i":
                                    $file=$_SERVER["DOCUMENT_ROOT"]."\..\muy_res".$row["percorso"];
                                    $image="data:image/png;base64,".base64_encode(file_get_contents($file));
                                    echo "<img class=\"oggetto\" src=\"".$image."\" onclick=\"document.getElementById('modal_bg_img').style.display='flex'\">";
                                    break;
                                default:
                                    break;
                            }
                        ?>
                    </div>
                    <div class="infobox">
                        <div class="info-head">
                            <div class="info-titolo"><h1><?php echo $row["titolo"]; ?></h1></div>
                            
                            
                            <div><h1 id="visual">
                                
                                <?php //echo $row["visualizzazioni"]; --visual con ajax-- ?>
                            
                                <?php
                                    $query="SELECT visualizzazioni FROM `oggettomultimediale` WHERE extID='".$_GET["id"]."'";
                                    $res=$connected_db->query($query);
                                    if(!$res){
                                        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                        $connected_db->close();
                                        exit();
                                    }
                                    $num=$res->fetch_assoc();

                                    $num=$num["visualizzazioni"]+1;

                                    $query="UPDATE `oggettomultimediale` SET visualizzazioni='".$num."' WHERE extID='".$_GET["id"]."'";
                                    $res=$connected_db->query($query);
                                    if(!$res){
                                        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                        $connected_db->close();
                                        exit();
                                    }

                                    echo $num;
                                ?>
                            
                            </h1></div>
                            
                            
                        </div>
                        <?php
                            if($error_connection["flag"]){
                                $redirect_with_error.=urlencode($error_connection["msg"]);
                                header($redirect_with_error);
                                exit();
                            }
                            $res=get_content_tag($row["percorso"],$connected_db);
                            echo "<div class=\"eticanale\" id=\"info-eti\">";
                            if($res->num_rows>0){
                                while($row_tag=$res->fetch_assoc())
                                    echo "<a class=\"etichetta\" href=\"categoria.php?tag=".htmlentities(urlencode(stripslashes($row_tag["tag"])))."\">".stripslashes($row_tag["tag"])."</a>";
                            }
                                #echo "<button class=\"add_button\" type=\"button\" onclick=\"add_eti('".$_GET["id"]."',this)\"></button>";
                            if($self){
                                echo "<input type=\"hidden\" name=\"newtag\" placeholder=\"#...\"/>";
                                echo "<button class=\"add_button\" type=\"button\" onclick=\"add_eti('".$_GET["id"]."',this)\"></button>";
                                echo "<button class=\"cross_button\" type=\"button\" style=\"display: none\" onclick=\"close_eti(this)\"></button>";
                            }
                            echo "</div>";
                        if(!empty($row["descrizione"]))
                            echo "<div class=\"info-descrizione\">".$row["descrizione"]."</div>";
                        else
                            echo "<div class=\"info-descrizione\">Nessuna descrizione</div>";
                        ?>
                    </div>
                </div>
                <div class="commentbox">
                    <div id="lista-commenti">
                        <?php
                            $query="SELECT * FROM commento JOIN utente ON commento.utente=utente.email WHERE contenuto='".escape($row["percorso"],$connected_db)."' ORDER BY dataRilascio ASC";
                            $res=$connected_db->query($query);
                            if($res->num_rows>0){
                                while($row=$res->fetch_assoc()){
                                    echo "<div class=\"commento\">";
                                        echo "<div class=\"comm-head\">";
                                            echo "<div class=\"flex-center\">";
                                                $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/../muy_res/".$row["foto"]));
                                                echo "<a href=\"user.php?user=".$row["email"]."\"><img class=\"comm-img\" src=\"".$pro_pic."\"></a>";
                                                echo "<a class=\"comm-aut\" href=\"user.php?user=".$row["email"]."\"><b>".$row["nickname"]."</b></a>";
                                            echo "</div>";
                                            echo "<div>";
                                            if($_SESSION["email"]==$row["email"])
                                                echo "<button class=\"delete-cross\" type=\"button\" onclick=\"delete_comment('".$row["id"]."','".$row["utente"]."',this)\">x</button>";
                                            echo "</div>";
                                        echo "</div>";
                                        echo "<div class=\"comm-text\">".$row["testo"]."</div>";
                                    echo "</div>";
                                }
                            }else
                                echo "<div id=\"no-comment\">Nessun commento</div>";
                        ?>                        
                    </div>
                    <div class="input-comment">
                        <textarea class="in_comment" id="comm" rows="3" placeholder="Commenta..."></textarea>
                        <?php
                            if(isset($_SESSION["nome"])){
                                $query="SELECT foto FROM utente WHERE email='".escape($_SESSION["email"],$connected_db)."'";
                                $res=$connected_db->query($query);
                                $row=$res->fetch_assoc();
                                $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/../muy_res/".$row["foto"]));
                                echo "<div class=\"com-button\"><button class=\"in_notext\" type=\"button\" onclick=\"comment(document.getElementById('comm'),'".$_GET['id']."',document.getElementById('lista-commenti'),'".$_SESSION['nome']."','".$pro_pic."','".$_SESSION['email']."')\">Commenta</button></div>";
                            }else
                                echo "<div class=\"com-button\"><button class=\"in_notext\" type=\"button\" onclick=\"comment(document.getElementById('comm'),'".$_GET['id']."',document.getElementById('lista-commenti'),'no','no')\">Commenta</button></div>";
                            $connected_db->close();
                        ?>
                    </div>
                </div>
            </div>
        </main>
    
    <div id="modal_bg_img" class="modal_bg">
        <?php echo "<img class=\"oggetto\" src=\"".$image."\">"; ?>
    </div>

    <script>
        var el=document.getElementById("modal_bg_img")
        el.onclick=function(event){
                el.style.display='none'
        }
        
        function close_eti(button){
            button.style.display = "none"
            document.getElementsByName("newtag")[0].value = ""
            document.getElementsByName("newtag")[0].type = "hidden"
        }
        
        //visual con ajax, se togli togli sopra e la funzione in _aux.js
        //window.onload = function(){visual(<?php echo $_GET["id"]; ?>)}
    </script>
    <script type="text/javascript" src="../common/script/setup.js"></script>
    <script type="text/javascript" src="../common/script/_aux.js"></script>

</body>

</html>