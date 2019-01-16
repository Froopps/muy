<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Home</title>
    
    <?php 
        include "../common/head.php";
        if($error_connection["flag"]){
            header("Location: http://localhost/pagina_errore");
            exit();
        }
    ?>
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
                        #edit span to achieve a fashion error displaying
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                    if(isset($_GET["msg"])){
                        #edit span to achieve a fashion message displaying
                        echo "<span class='message_span'>".$_GET["msg"]."</span>";
                    }
                ?>
                <div class="categoria">
                    <?php
                        echo "<div><a class='categoria_titolo' href='categoria.php?tag=".htmlentities(urlencode("Most visited videos")."&s=true")."'>Most visited videos</a></div>"
                    ?>
                    <div class="scrollbar">
                        <?php
                            $query="SELECT * FROM oggettoMultimediale WHERE tipo='v' ORDER BY visualizzazioni DESC LIMIT 10";
                        ?>
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
                    <?php
                        echo "<div><a class='categoria_titolo' href='categoria.php?tag=".htmlentities(urlencode("Most visited audios")."&s=true")."'>Most visited audios</a></div>"
                    ?>
                    <div class="scrollbar">
                        <?php
                            $query="SELECT * FROM oggettoMultimediale WHERE tipo='a' ORDER BY visualizzazioni DESC LIMIT 10";
                        ?>
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
                    <?php
                        echo "<div><a class='categoria_titolo' href='categoria.php?tag=".htmlentities(urlencode("Most visited images")."&s=true")."'>Most visited images</a></div>"
                    ?>
                    <div class="scrollbar">
                        <?php
                            $query="SELECT * FROM oggettoMultimediale WHERE tipo='i' ORDER BY visualizzazioni DESC LIMIT 10";
                        ?>
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
                    <div><a class="categoria_titolo" href="#seeee">Procedurali</a></div>
                    <div class="scrollbar">
                        <?php
                            $query="SELECT * FROM oggettoMultimediale WHERE tipo='i' ORDER BY visualizzazioni DESC LIMIT 10";
                        ?>
                        <?php
                            $query="SELECT * FROM `oggettomultimediale` WHERE 1";
                            $res=$connected_db->query($query);
                            if(!$res){
                                $connected_db->close();
                                exit();
                            }
                            while($row=$res->fetch_assoc()){
                                display_multimedia_object($row,$connected_db);
                            }
                            $connected_db->close();
                        ?>
                    </div>
                </div>
                
            </div>

        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
</body>

</html>