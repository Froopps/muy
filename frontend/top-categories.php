<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MUY | Top categories</title>
    
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
            $top=get_top_tags($connected_db);
            if(!isset($top))
                $_GET['error']='Errore nella connessione col server';
        ?>

        <main>
            <div class="content">
                <?php
                    if(isset($_GET["error"])){
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                        if(!($top))
                            exit();
                    }
                    if(isset($_GET["msg"])){
                        echo "<span class='message_span'>".$_GET["msg"]."</span>";
                    }
                ?>

                <table id="classifica_cat">
                    <?php
                        $count=0;
                        echo "<tr>";
                        if($top->num_rows==0)
                                echo "<span class='message_span'>Non ci sono ancora etichette</span>";
                        while($row=$top->fetch_assoc()){
                            $count++;
                            if($count==6)
                                echo "</tr><tr>";
                            echo "<td class=\"eti_position\"><h1>#$count</h1></td>";
                            echo "<td class=\"tab_top_cat\">";
                                display_tag_mosaic($row["tag"],$connected_db);
                            echo "</td>";
                        }
                        echo "</tr>";
                    ?>
                </table>

            </div>
        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
        <script type="text/javascript" src="../common/script/setup.js"></script>
</body>

</html>