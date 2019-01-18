<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | <?php echo $tag=$_GET["tag"]; ?></title>
    
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
                <div class="flex-space-between">
                    <span><h2><?php echo $tag; ?></h2></span>
                    <span>
                        Ordina:
                        <select name="sort">
                            <option value="visual">Visualizzazioni</option>
                            <option value="rating">Voto</option>
                            <option value="newest">Più recenti</option>
                            <option value="oldest">Più vecchi</option>
                        </select>
                    </span>
                </div>
                <div>
                    <?php
                        if(isset($_GET["s"]))
                            $redirect_with_error="Location: http://localhost/muy/frontend/categoria.php?tag=".htmlentities(urlencode($_GET["tag"]))."&s=true&error=";
                        else
                            $redirect_with_error="Location: http://localhost/muy/frontend/categoria.php?tag=".htmlentities(urlencode($_GET["tag"]))."error=";
                        if($error_connection["flag"]){
                            $redirect_with_error.=urlencode($error_connection["msg"]);
                            header($redirect_with_error);
                            exit();
                        }
                        if(isset($_GET["s"])){
                            #casi speciali
                            if($_GET["s"]=="c"){
                                $query="SELECT * FROM oggettomultimediale WHERE canale='".escape($_GET["tag"],$connected_db)."' AND proprietario='".escape($_GET["user"],$connected_db)."' ORDER BY `dataCaricamento` DESC";
                                $res=$connected_db->query($query);
                                if(!$res){
                                    $redirect_with_error.=urlencode("Errore nella connessione con il database");
                                    log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                    header($redirect_with_error);
                                    $connected_db->close();
                                    exit();
                                }
                                $no_content=1;
                                while($row=$res->fetch_assoc()){
                                    display_multimedia_object($row,$connected_db);
                                    $no_content=0;
                                }
                                if($no_content)
                                    echo "<span class='message_span'>Non c'è nessun elemento da mostrare</span>";
                            }else
                                echo "yes ".$_GET["s"];
                        }else{
                            $query="SELECT percorso, anteprima, titolo, descrizione, tipo, dataCaricamento, visualizzazioni, canale, proprietario FROM contenutotaggato JOIN oggettomultimediale ON (contenutotaggato.oggetto = oggettomultimediale.percorso) WHERE tag='".escape($tag,$connected_db)."'";
                            $res=$connected_db->query($query);
                            if(!$res){
                                $redirect_with_error.=urlencode("Errore nella connessione con il database");
                                log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                header($redirect_with_error);
                                $connected_db->close();
                                exit();
                            }
                            while($row=$res->fetch_assoc()){
                                display_multimedia_object($row,$connected_db);
                            }
                        }
                        $connected_db->close();
                    ?>
                </div>
            </div>
        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
        <script type="text/javascript" src="../common/script/setup.js"></script>
</body>

</html>