<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Base</title>
    
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
                
                <img src="../sources/images/cover.jpg">
            </div>
        </main>

</body>

</html>