<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | <?php echo $canale=$_GET["canale"]; ?></title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>

    <?php 
            include "../common/header_logged.php";
            include "../common/sidebar_logged.php";
    ?>

        <main>
            <div class="content">
                <?php
                    print_r($_SESSION);
                    $redirect_with_error="Location: http://localhost/muy/frontend/user.php?error=";
                    if($error_connection["flag"]){
                        $redirect_with_error.=urlencode($error_connection["msg"]);
                        header($redirect_with_error);
                        exit();
                    }
                    $query="SELECT * FROM `oggettomultimediale` WHERE canale='".escape($canale,$connected_db)."' AND proprietario='".escape($_SESSION["email"],$connected_db)."'";
                    $res=$connected_db->query($query);
                    if(!$res){
                        $connected_db->close();
                        exit();
                    }
                
                    echo "<table>";
                    echo "<tr><th>Titolo</th><th>Descrizione</th><th>Tipo</th><th>Data di caricamento</th><th>Visualizzazioni</th><th>Elimina</th></tr>";
                    while($row=$res->fetch_assoc()){
                        echo "<tr><td>".stripslashes($row["titolo"])."</td><td>".stripslashes($row["descrizione"])."</td><td>".stripslashes($row["tipo"])."</td><td>row[\"datacariCamento\"]</td><td>".$row["visualizzazioni"]."</td>";
                        echo "<td><a class=\"glyph-button\" href=\"../backend/delete_script.php?canale=".htmlentities(urlencode($_GET["canale"]))."&oggetto=".htmlentities(urlencode($row["percorso"]))."\"><img src=\"../sources/images/trash.png\" width=\"30px\" alt=\"Cancella\"></a></td></tr>";
                    }
                    echo "</table>";
                
                    $query="SELECT * FROM `oggettomultimediale` WHERE canale='".escape($canale,$connected_db)."'";
                    $res=$connected_db->query($query);
                    if(!$res){
                    $connected_db->close();
                        exit();
                    }
                    while($row=$res->fetch_assoc()){
                        display_multimedia_object($row,$connected_db);
                        echo "<div><a class=\"glyph-button\" href=\"../backend/delete_script.php?channel=".htmlentities(urlencode($row["canale"]))."video=".htmlentities(urlencode($row["percorso"]))."\"><img src=\"../sources/images/trash.png\" width=\"30px\" alt=\"Cancella\"></a></div>";
                    }
                    $connected_db->close();
                ?>
            </div>
        </main>

</body>

</html>