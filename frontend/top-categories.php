<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Top categories</title>
    
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
            <div class="content">
                <?php
                    if(isset($_GET["error"])){
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                    if(isset($_GET["msg"])){
                        echo "<span class='message_span'>".$_GET["msg"]."</span>";
                    }
                ?>

                <table id="classifica_cat">
                    <tr>
                        <td class="eti_position"><h1>#1</h1></td>
                        <td class="tab_top_cat"><?php display_tag_mosaic("#tit",$connected_db); ?></td>
                        <td class="eti_position"><h1>#2</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                        <td class="eti_position"><h1>#3</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                        <td class="eti_position"><h1>#4</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                        <td class="eti_position"><h1>#5</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                    </tr>
                    <tr>
                        <td class="eti_position"><h1>#6</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                        <td class="eti_position"><h1>#7</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                        <td class="eti_position"><h1>#8</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                        <td class="eti_position"><h1>#9</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                        <td class="eti_position"><h1>#10</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
                    </tr>
                </table>

            </div>
        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
        <script type="text/javascript" src="../common/script/setup.js"></script>
</body>

</html>