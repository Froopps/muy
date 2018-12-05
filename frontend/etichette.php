<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Etichette</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../images/icon.gif" rel="icon" type="../image/gif">
	<link rel="stylesheet" type="text/css" href="../css/my.css"/>
</head>

<body>

        <!-- controllo loggato -->
        <?php 
            if(isset($_SESSION["logged"])){
                if($_SESSION["logged"]==true){
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
                <h5>A</h5><hr>
                <a href="#categoria"><h2>Affreschi</h2></a>
                <h5>B</h5><hr>
                <h5>C</h5><hr>
                <h5>D</h5><hr>
                <h5>E</h5><hr>
                <h5>F</h5><hr>
                <h5>G</h5><hr>
                <h5>H</h5><hr>
                <h5>I</h5><hr>
                <h5>J</h5><hr>
                <h5>K</h5><hr>
                <h5>L</h5><hr>
                <h5>M</h5><hr>
                <h5>N</h5><hr>
                <h5>O</h5><hr>
                <h5>P</h5><hr>
                <h5>Q</h5><hr>
                <h5>R</h5><hr>
                <h5>S</h5><hr>
                <h5>T</h5><hr>
                <h5>U</h5><hr>
                <h5>V</h5><hr>
                <h5>W</h5><hr>
                <h5>X</h5><hr>
                <h5>Y</h5><hr>
                <h5>Z</h5><hr>
                <h5>#</h5><hr>
                <h5>!?%</h5><hr>
            </div>

        </main>

</body>

</html>