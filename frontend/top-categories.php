<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Top categories</title>
    
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

                <table id="classifica_cat">
                    <tr>
                        <td class="eti_position"><h1>#1</h1></td>
                        <td class="tab_top_cat"><?php include "../common/mosaico.html"; ?></td>
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

</body>

</html>