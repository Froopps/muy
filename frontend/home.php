<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Home</title>
    
    <?php 
        include "../common/head.html";
        include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
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
            include "../common/sidebar_logged.html";
        }else{
            include "../common/header_unlogged.html";
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
                ?>
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#mvvideos">Most visited videos</a></div>
                    <div class="scrollbar">
                        <table>
                            <tr>
                            <?php
                                $query="SELECT * FROM oggettoMultimediale WHERE tipo='v' ORDER BY visualizzazione DESC LIMIT 10";
                            
                                /*<td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>*/
                            ?>
                            <td><button id="arrow"><img src="../sources/images/arrow.png" width="100px" alt="Mostra altro"></button></td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#avaudios">Most visited audios</a></div>
                    <div class="scrollbar">
                        <table>
                            <tr>
                            <?php
                                $query="SELECT * FROM oggettoMultimediale WHERE tipo='a' ORDER BY visualizzazione DESC LIMIT 20";
            
                                /*<td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>*/
                            ?>
                            <td><button id="arrow"><img src="../sources/images/arrow.png" width="100px" alt="Mostra altro"></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#mvimages">Most visited images</a></div>
                    <div class="scrollbar">
                        <table>
                            <tr>
                            <?php
                                $query="SELECT * FROM oggettoMultimediale WHERE tipo='i' ORDER BY visualizzazione DESC";
                            
                                /*<td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>
                                <td><?php include "../common/multimedia_object.html"; ?></td>*/
                            ?>
                            <td><button id="arrow"><img src="../sources/images/arrow.png" width="100px" alt="Mostra altro"></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </main>

</body>

</html>