<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | User</title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>

        <!-- controllo loggato -->
        <?php 
            if(isset($_SESSION["email"])){
                include "../common/header_logged.php";
                include "../common/sidebar_logged.html";
            }else{
                include "../common/header_unlogged.php";
                include "../common/sidebar_unlogged.html";
            }
        ?>

        <main>

            <div class="content">
                
                <div id="testa">
                    <?php
                        $redirect_with_error="Location: http://localhost/muy/home.php?error=";
                        if($error_connection["flag"]){
                            $redirect_with_error.=urlencode($error_connection["msg"]);
                            header($redirect_with_error);
                            exit();
                        }
                        $query="SELECT * FROM utente WHERE email='".$_GET["user"];
                        $query.="'";
                        $res=$connected_db->query($query);
                        if(!$res){
                            $redirect_with_error.="Errore nella connessione con il database";
                            log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                            header($redirect_with_error);
                            $connected_db->close();
                            exit();
                        }
                        $row=$res->fetch_assoc();
                        user_info($row);
                    ?>
                    <!--?php include "../common/user_info.html"; ?-->
                </div>
                
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#canale1">Canale 1</a></div>
                    <div class="eticanale">
                        <a class="etichetta" href="#etichetta">#affreschi</a>
                        <a class="etichetta" href="#etichetta">#sport</a>
                    </div>
                    <div class="scrollbar">
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                    </div>
                </div>
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#canale2">Canale 2</a></div>
                    <div class="eticanale">
                        <a class="etichetta" href="#etichetta">#lezioni di scienze</a>
                    </div>
                    <div class="scrollbar">
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                        <div id="arrowbox">
                            <p class=arrow_txt>Mostra altro</p>
                            <button id="arrow"><img src="../sources/images/arrow.png" width="100px" alt="Mostra altro"></button>
                        </div>
                    </div>
                </div>
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#canale3">Canale 3</a></div>
                    <div class="eticanale">
                        <a class="etichetta" href="#etichetta">#spazzatura</a>
                    </div>
                    <div class="scrollbar">
                        <?php include "../common/multimedia_object.html"; ?>
                        <?php include "../common/multimedia_object.html"; ?>
                    </div>
                </div>
                
            </div>

        </main>

</body>

</html>