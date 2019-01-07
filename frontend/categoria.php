<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | #<?php echo $tag=str_replace("_"," ",$_GET["tag"]); ?></title>
    
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
                <div class="flex-space-between">
                    <span><h2>#<?php echo $tag; ?></h2></span>
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
                            $redirect_with_error="Location: http://localhost/muy/frontend/categoria.php?tag=".$_GET["tag"]."&s=true&error=";
                        else
                            $redirect_with_error="Location: http://localhost/muy/frontend/categoria.php?tag=".$_GET["tag"]."error=";
                        if($error_connection["flag"]){
                            $redirect_with_error.=urlencode($error_connection["msg"]);
                            header($redirect_with_error);
                            exit();
                        }
                        if(isset($_GET["s"])){
                            #casi speciali
                            echo "yes";
                        }else{
                            $query="SELECT percorso, anteprima, titolo, descrizione, tipo, dataCaricamento, visualizzazioni, canale, proprietario FROM contenutotaggato JOIN oggettomultimediale ON (contenutotaggato.oggetto = oggettomultimediale.percorso) WHERE tag='#".$tag."'";
                            $res=$connected_db->query($query);
                            if(!$res){
                                $redirect_with_error.="Errore nella connessione con il database";
                                log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                header($redirect_with_error);
                                $connected_db->close();
                                exit();
                            }
                            while($row=$res->fetch_assoc()){
                                display_multimedia_object($row,$connected_db);
                            }
                        }
                    ?>
                </div>
            </div>
        </main>

</body>

</html>