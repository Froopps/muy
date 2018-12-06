<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | User</title>
    
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
                
                <div id="testa">
                    <?php include "../common/user_info.html"; ?>
                </div>
                
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#canale1">Canale 1</a></div>
                    <div class="eticanale">
                        <a class="etichetta" href="#etichetta">#affreschi</a>
                        <a class="etichetta" href="#etichetta">#sport</a>
                    </div>
                    <div class="scrollbar">
                        <table>
                            <tr>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#canale2">Canale 2</a></div>
                    <div class="eticanale">
                        <a class="etichetta" href="#etichetta">#lezioni di scienze</a>
                    </div>
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
                            <td><button id="arrow"><img src="../sources/images/arrow.png" width="100px"></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="categoria">
                    <div><a class="categoria_titolo" href="#canale3">Canale 3</a></div>
                    <div class="eticanale">
                        <a class="etichetta" href="#etichetta">#spazzatura</a>
                    </div>
                    <div class="scrollbar">
                        <table>
                            <tr>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            <td><?php include "../common/multimedia_object.html"; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
            </div>

        </main>

</body>

</html>