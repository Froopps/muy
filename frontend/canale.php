<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=";

    if(!(isset($_GET['nome'])&&isset($_GET['proprietario']))){
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        header($redirect_with_error);
        $connected_db->close();
        exit();
    }
    $query="SELECT * FROM oggettoMultimediale WHERE canale='".escape($_GET["nome"],$connected_db)."' AND proprietario='".escape($_GET["proprietario"],$connected_db)."' ORDER BY `dataCaricamento` DESC";
    $res=$connected_db->query($query);
    if(!$res){
        $redirect_with_error.=urlencode("Errore nella connessione con il database");
        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
        header($redirect_with_error);
        $connected_db->close();
        exit();
    }
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Canale</title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>
    
        <!-- controllo loggato -->
        <?php 
            if(isset($_SESSION["email"])){
                include "../common/header_logged.php";
                include "../common/sidebar_logged.php";
            }
            else{
                include "../common/header_unlogged.php";
                include "../common/sidebar_unlogged.html";
            }
        ?>

        <main>
            <div class='content'>
            <?php 
            echo "<h2>".$_GET['nome']."</h2>";
            ?>
            <div class="channel_view">
                <?php
                    if(isset($_GET["error"])){
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                    if(isset($_GET["msg"])){
                        echo "<span class='message_span'>".$_GET["msg"]."</span>";
                    }
                    $no_content=1;
                    while($row=$res->fetch_assoc()){
                        display_multimedia_object($row,$connected_db);
                        $no_content=0;
                    }
                    if($no_content)
                        echo "<span class='message_span'>Non c'è nessun elemento da mostrare</span>";
                ?>
            </div>
            </div>
        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
        <script type="text/javascript" src="../common/script/setup.js"></script>
</body>