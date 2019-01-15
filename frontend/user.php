<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
    <?php
        $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=";
        if($error_connection["flag"]){
            $redirect_with_error.=urlencode($error_connection["msg"]);
            header($redirect_with_error);
            exit();
        }
        $res=get_user_by_email($_GET["user"],$connected_db);
        $row=$res->fetch_assoc();
        if(!$res||$row['COUNT(*)']<=0){
            $redirect_with_error.=urlencode("Errore nella connessione con il database ");
            header($redirect_with_error);
            exit();
        }
        
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
                <?php
                    if(isset($_GET["error"])){
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                    if(isset($_GET["msg"])){
                        echo "<span class='message_span'>".$_GET["msg"]."</span>";
                    }
                ?>
                
                <div id="testa-user">
                    <?php
                        
                        display_user_info($row,$connected_db);
                    ?>
                </div>
                
                <?php
                    $res=get_channel_by_owner($_GET["user"],$connected_db);
                    if(!$res){
                        $redirect_with_error.=urlencode("Errore nella connessione con il database");
                        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                        header($redirect_with_error);
                        $connected_db->close();
                        exit();
                    }
                    $no_channel=1;
                    $no_content=1;
                    while($row=$res->fetch_assoc()){
                        $no_channel=0;
                        echo "<div class=\"categoria\">";
                            echo "<div class=\"categoria_user_nome\">";
                                echo "<a class=\"categoria_titolo\" href=\"categoria.php?tag=".htmlentities(urlencode($row["nome"]))."&s=c&user=".htmlentities(urlencode($_GET["user"]))."\">".stripslashes($row["nome"])."</a>";
                                echo "<div>";
                                    echo "<a class=\"glyph-button\" href=\"channel_mod.php?canale=".htmlentities(urlencode($row["nome"]))."\"><img src=\"../sources/images/pencil.png\" width=\"30px\" alt=\"Modifica\"></a>";
                                    echo "<a class=\"glyph-button\" href=\"upload.php?canale=".htmlentities(urlencode($row["nome"]))."\"><img src=\"../sources/images/plus.png\" width=\"30px\" alt=\"Aggiungi\"></a>";
                                echo "</div>";
                            echo "</div>";
                            echo "<hr align=\"left\">";
                            echo "<div class=\"eticanale\">";
                                    $eti=explode(",",$row["etichetta"]);
                                    foreach($eti as $et){
                                        echo "<a class='etichetta' href='#etichetta'>#".stripslashes($et)."</a>";
                                    }
                            echo "</div>";
                            echo "<div class=\"scrollbar\">";
                                $query="SELECT * FROM oggettomultimediale WHERE canale='".escape($row["nome"],$connected_db)."'";
                                $res_ogg=$connected_db->query($query);
                                if(!$res_ogg){
                                    $redirect_with_error.=urlencode("Errore nella connessione con il database");
                                    log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                    header($redirect_with_error);
                                    $connected_db->close();
                                    exit();
                                }
                                $no_content=1;
                                while($row_ogg=$res_ogg->fetch_assoc()){
                                    $no_content=0;
                                    display_multimedia_object($row_ogg,$connected_db);
                                }
                                if($no_content)
                                    echo "<span class='message_span'>Non c'è nessun elemento da mostrare</span>";
                            echo "</div>";
                        echo "</div>";                    
                    }
                    if($no_channel)
                        echo "<span class='message_span'>Non c'è nessun canale da mostrare</span>";
                    $connected_db->close();
                ?>
                
            </div>

        </main>
    <script type="text/javascript" src="../common/script/setup.js"></script>
    <script type="text/javascript" src="../common/script/friendship.js"></script>

</body>

</html>