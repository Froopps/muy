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
                        $redirect_with_error.=urlencode("Errore nella connessione con il database");
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
                        echo "<a class='oggetto-canale' href=\"categoria.php?tag=".htmlentities(urlencode($eti))."\">".$eti."</a><br>";
                    }
                    $connected_db->close();
                ?>
            </div>

        </main>

</body>

</html>