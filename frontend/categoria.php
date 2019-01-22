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
                <div class="categoria">
                <h2><?php echo $tag; ?></h2>
                <div>
                    <?php
                        if($error_connection["flag"]){
                            echo "<span class='error_span>Errore nella connessione col server</span>";
                            exit();
                        }
                        $query="SELECT * FROM contenutoTaggato JOIN oggettoMultimediale ON (contenutoTaggato.oggetto = oggettoMultimediale.percorso) WHERE tag='".escape($tag,$connected_db)."'";
                        $res=$connected_db->query($query);
                        if(!$res){
                            log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                            echo "<span class='error_span>Errore nella connessione col server</span>";
                            exit();
                        }
                        while($row=$res->fetch_assoc()){
                            display_multimedia_object($row,$connected_db);
                        }
                    ?>
                </div>
                </div>
            </div>
        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
        <script type="text/javascript" src="../common/script/setup.js"></script>
</body>

</html>