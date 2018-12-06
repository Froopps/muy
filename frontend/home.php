<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Home</title>
    
    <?php include "../common/head.html"; ?>
</head>

<body>
    
        <!-- controllo loggato -->
        <?php 
            if(isset($_SESSION["logged"])){
                if($_SESSION["logged"]){
                    include "../common/header_logged.html";
                    include "../common/sidebar_logged.html";
                }else{
                    include "../common/header_unlogged.html";
                    include "../common/sidebar_unlogged.html";
                }
            }else{
                include "../common/header_unlogged.html";
                include "../common/sidebar_unlogged.html";
            }
        ?>

        <main>

            <div class="content">
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#mvvideos">Most visited videos</a></div>
                    <div class="scrollbar">
                        <table>
                            <tr>
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
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
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
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
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
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><button id="arrow"><img src="../sources/images/arrow.png" width="100px" alt="Mostra altro"></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </main>

</body>

</html>