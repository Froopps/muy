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
                <select name="visualizza" onchange="show()">
                    <option value="el">Elenco</option>
                    <option value="tab">Tabella</option>
                </select>
                <?php
                    print_r($_SESSION);
                    $redirect_with_error="Location: http://localhost/muy/frontend/user.php?error=";
                    if($error_connection["flag"]){
                        $redirect_with_error.=urlencode($error_connection["msg"]);
                        header($redirect_with_error);
                        exit();
                    }
                    $query="SELECT * FROM `oggettomultimediale` WHERE canale='".escape($canale,$connected_db)."' AND proprietario='".escape($_SESSION["email"],$connected_db)."' ORDER BY `dataCaricamento` DESC";
                    $res=$connected_db->query($query);
                    if(!$res){
                        $connected_db->close();
                        exit();
                    }
                    $no_content=1;
                    echo "<table id=\"tabella\" sytle=\"display: none\">";
                    echo "<tr><th>Titolo</th><th>Descrizione</th><th>Tipo</th><th>Data di caricamento</th><th>Visualizzazioni</th><th>Elimina</th></tr>";
                    while($row=$res->fetch_assoc()){
                        echo "<tr><td>".stripslashes($row["titolo"])."</td><td>".stripslashes($row["descrizione"])."</td><td>".stripslashes($row["tipo"])."</td><td>row[\"datacariCamento\"]</td><td>".$row["visualizzazioni"]."</td>";
                        echo "<td><a class=\"glyph-button\" href=\"../backend/delete_script.php?canale=".htmlentities(urlencode($_GET["canale"]))."&oggetto=".htmlentities(urlencode($row["percorso"]))."\"><img src=\"../sources/images/trash.png\" width=\"30px\" alt=\"Cancella\"></a></td></tr>";
                        $no_content=0;
                    }
                    echo "</table>";
                    if($no_content)
                        echo "<span class='message_span'>Non hai ancora caricato nessun contenuto</span>";
                
                    $query="SELECT * FROM `oggettomultimediale` WHERE canale='".escape($canale,$connected_db)."' AND proprietario='".escape($_SESSION["email"],$connected_db)."' ORDER BY `dataCaricamento` DESC";
                    $res=$connected_db->query($query);
                    if(!$res){
                        $connected_db->close();
                        exit();
                    }
                    $no_content=1;
                    echo "<div class=\"categoria\" id=\"elenco\" sytle=\"display: block\">";
                    while($row=$res->fetch_assoc()){
                        echo "<span class=\"obj_mod\">";
                        echo "<div align='center'><a class=\"glyph-button\" href=\"../backend/delete_script.php?channel=".htmlentities(urlencode($row["canale"]))."video=".htmlentities(urlencode($row["percorso"]))."\"><img src=\"../sources/images/trash.png\" width=\"30px\" alt=\"Cancella\"></a></div>";
                        display_multimedia_object($row,$connected_db);
                        echo "</span>";
                        $no_content=0;
                    }
                    if($no_content)
                        echo "<span class='message_span'>Non hai ancora caricato nessun contenuto</span>";
                    echo "</div>";
                    $connected_db->close();
                ?>
            </div>
        </main>
    
    <script>
            document.getElementById("tabella").style.display = "none"
        function show(){
            var sel = document.getElementsByName("visualizza")[0]
            if (sel.value=="tab"){
                document.getElementById("tabella").style.display = "block"
                document.getElementById("elenco").style.display = "none"
            } else {
                document.getElementById("tabella").style.display = "none"
                document.getElementById("elenco").style.display = "block"
            }
        }
    </script>

</body>

</html>