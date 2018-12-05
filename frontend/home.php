<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Home</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../images/icon.gif" rel="icon" type="../image/gif">
	<link rel="stylesheet" type="text/css" href="../css/my.css"/>
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
                    <div><a class="categoria_titolo" href="#categoria1">Categoria contenuto 1</a></div>
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
                </div>
                    <div class="categoria">
                    <div><a class="categoria_titolo" href="#categoria2">Categoria contenuto 2</a></div>
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
                </div>
            </div>

        <main>

</body>

</html>