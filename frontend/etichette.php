<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
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
                <?php
                    $redirect_with_error="Location: http://localhost/muy/frontend/etichette.php?error=";
                        if($error_connection["flag"]){
                            $redirect_with_error.=urlencode($error_connection["msg"]);
                            header($redirect_with_error);
                            exit();
                        }
                    $query="SELECT tag FROM categoria WHERE 1 ORDER BY tag ASC";
                    $res=$connected_db->query($query);
                    if(!$res){
                        $redirect_with_error.="Errore nella connessione con il database";
                        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                        header($redirect_with_error);
                        $connected_db->close();
                        exit();
                    }
                    while($row=$res->fetch_assoc()){
                        $tag[]=$row["tag"];
                    }
                    $current_letter="";
                    foreach($tag as $eti){
                        $letter=$eti[1];
                        if($current_letter==""){
                            echo "<h2>".strtoupper($letter)."</h2><hr class='short_hr'>";
                            $current_letter=$letter;
                        }else if($letter!=$current_letter){
                            echo "<div class='spazio-vert'></div><h2>".strtoupper($letter)."</h2><hr class='short_hr'>";
                            $current_letter=$letter;
                        }
                        echo "<a class='oggetto-canale' href=\"categoria.php?tag=".str_replace(" ","_",substr($eti,1))."\">".$eti."</a><br>";
                    }
                    $connected_db->close();
                ?>
<!--
                <h2>A</h2><hr class="short_hr">
                    <a class="oggetto-canale" href="#categoria">Affreschi</a><br>
                    <a class="oggetto-canale" href="#categoria">Astronavi</a><br>
                <div class="spazio-vert"></div><h2>B</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>C</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>D</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>E</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>F</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>G</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>H</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>I</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>J</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>K</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>L</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>M</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>N</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>O</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>P</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>Q</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>R</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>S</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>T</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>U</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>V</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>W</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>X</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>Y</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>Z</h2><hr class="short_hr">
                <div class=spazio-vert></div><h2>!?%</h2><hr class="short_hr">
-->
            </div>

        </main>

</body>

</html>