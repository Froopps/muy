<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Etichette</title>
    
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
                <h2>A</h2><hr>
                    <a class=oggetto-canale href="#categoria">Affreschi</a><br>
                    <a class=oggetto-canale href="#categoria">Astronavi</a><br>
                <div class=spazio-vert></div><h2>B</h2><hr>
                <div class=spazio-vert></div><h2>C</h2><hr>
                <div class=spazio-vert></div><h2>D</h2><hr>
                <div class=spazio-vert></div><h2>E</h2><hr>
                <div class=spazio-vert></div><h2>F</h2><hr>
                <div class=spazio-vert></div><h2>G</h2><hr>
                <div class=spazio-vert></div><h2>H</h2><hr>
                <div class=spazio-vert></div><h2>I</h2><hr>
                <div class=spazio-vert></div><h2>J</h2><hr>
                <div class=spazio-vert></div><h2>K</h2><hr>
                <div class=spazio-vert></div><h2>L</h2><hr>
                <div class=spazio-vert></div><h2>M</h2><hr>
                <div class=spazio-vert></div><h2>N</h2><hr>
                <div class=spazio-vert></div><h2>O</h2><hr>
                <div class=spazio-vert></div><h2>P</h2><hr>
                <div class=spazio-vert></div><h2>Q</h2><hr>
                <div class=spazio-vert></div><h2>R</h2><hr>
                <div class=spazio-vert></div><h2>S</h2><hr>
                <div class=spazio-vert></div><h2>T</h2><hr>
                <div class=spazio-vert></div><h2>U</h2><hr>
                <div class=spazio-vert></div><h2>V</h2><hr>
                <div class=spazio-vert></div><h2>W</h2><hr>
                <div class=spazio-vert></div><h2>X</h2><hr>
                <div class=spazio-vert></div><h2>Y</h2><hr>
                <div class=spazio-vert></div><h2>Z</h2><hr>
                <div class=spazio-vert></div><h2>#</h2><hr>
                <div class=spazio-vert></div><h2>!?%</h2><hr>
            </div>

        </main>

</body>

</html>