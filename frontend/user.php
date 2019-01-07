<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
    <?php
        $redirect_with_error="Location: http://localhost/muy/frontend/user.php?error=";
        if($error_connection["flag"]){
            $redirect_with_error.=urlencode($error_connection["msg"]);
            header($redirect_with_error);
            exit();
        }
        $res=get_user_by_email($_GET["user"],$connected_db);
        if(!$res){
            $redirect_with_error.="Errore nella connessione con il database";
            log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
            header($redirect_with_error);
            $connected_db->close();
            exit();
        }
        $row=$res->fetch_assoc();
        echo "<title>MyUNIMIYoutube | ".$row["nickname"]."</title>";
    
        include "../common/head.php";
    ?>
</head>

<body>

        <!-- controllo loggato -->
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
                
                <div id="testa-user">
                    <?php
                        display_user_info($row);
                    ?>
                </div>
                
                <?php
                    $res=get_channel_by_owner($_GET["user"],$connected_db);
                    if(!$res){
                        $redirect_with_error.="Errore nella connessione con il database";
                        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                        header($redirect_with_error);
                        $connected_db->close();
                        exit();
                    }
                    while($row=$res->fetch_assoc()){
                        echo "<div class=\"categoria\">";
                            echo "<div class=\"categoria_user_nome\">";
                                echo "<a class=\"categoria_titolo\" href=\"#canale1\">".$row["nome"]."</a>";
                                echo "<div>";
                                    echo "<a class=\"plus_logo\" href=\"channel_mod.php?canale=".str_replace(" ","_",$row["nome"])."\"><img src=\"../sources/images/pencil.png\" width=\"30px\" alt=\"Modifica\"></a>";
                                    echo "<a class=\"plus_logo\" href=\"upload.php?canale=".str_replace(" ","_",$row["nome"])."\"><img src=\"../sources/images/plus.png\" width=\"30px\" alt=\"Aggiungi\"></a>";
                                echo "</div>";
                            echo "</div>";
                            echo "<hr align=\"left\">";
                            echo "<div class=\"eticanale\">";
                                    $eti=explode(",",$row["etichetta"]);
                                    foreach($eti as $et){
                                        echo "<a class='etichetta' href='#etichetta'>#".$et."</a>";
                                    }
                            echo "</div>";
                            echo "<div class=\"scrollbar\">";
                                $query="SELECT * FROM oggettomultimediale WHERE canale='".$row["nome"]."'";
                                $res_ogg=$connected_db->query($query);
                                if(!$res_ogg){
                                    $redirect_with_error.="Errore nella connessione con il database";
                                    log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                    header($redirect_with_error);
                                    $connected_db->close();
                                    exit();
                                }
                                while($row_ogg=$res_ogg->fetch_assoc()){
                                    display_multimedia_object($row_ogg,$connected_db);
                                }
                            echo "</div>";
                        echo "</div>";                    
                    }
                    $connected_db->close();
                ?>
                
            </div>

        </main>

</body>

</html>