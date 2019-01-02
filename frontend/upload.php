<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Registrazione</title>
	
    <?php include "../common/head.php"; ?>
</head>

<body>

        <?php
            include "../common/header_logged.php";
            include "../common/sidebar_logged.php";
        ?>

        <main>

            <div class="content">
                <form enctype="multipart/form-data" action="../backend/upload.php" method="post">
                    <table id="signup-table">
                        <?php
                            if(isset($_GET["error"])){
                                echo "<tr><td class='error' colspan='2'>".$_GET["error"]."</td></tr>";
                            }
                        ?>
                        <tr>
                            <td>Upload file:</td>
                            <td class="left">
                                <input type="hidden" name="MAX_FILE_SIZE" value="10000000000"/>
                                <input type="file" name="file" accept="" required>
                            </td>
                        </tr>
                        <tr><td>Canale:</td><td class="left">
                            <select name="channel" required>
                                <?php
                                    $redirect_with_error="Location: http://localhost/muy/home.php?error=";
                                    if($error_connection["flag"]){
                                        $redirect_with_error.=urlencode($error_connection["msg"]);
                                        header($redirect_with_error);
                                        exit();
                                    }
                                    $query="SELECT nome FROM canale WHERE proprietario='".$_SESSION["email"];
                                    $query.="'";
                                    $res=$connected_db->query($query);
                                    if(!$res){
                                        $redirect_with_error.="Errore nella connessione con il database";
                                        log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                        header($redirect_with_error);
                                        $connected_db->close();
                                        exit();
                                    }
                                    while($row=$res->fetch_assoc()){
                                        echo "<option value='".$row["nome"]."'";
                                        // se arrivi da user seleziona automaticamente il canale
                                        if(isset($_GET["canale"]) && str_replace("_"," ",$_GET["canale"])==$row["nome"]){
                                            echo " selected";
                                        }
                                        echo ">".$row["nome"]."</option>";
                                    }
                                ?>
                            </select></td></tr>
                        <tr><td>Titolo:</td><td class="left"><input type="text" name="title" placeholder="Titolo" required></td></tr>
                        <tr><td>Descrizione:</td><td class="left"><textarea name="desc" placeholder="Descrizione" cols="54" rows="3"></textarea></td></tr>
                        <tr><td>Tipo:</td><td class="left">
                            <select name="type" required>
                                <option value="v">Video</option>
                                <option value="a">Audio</option>
                                <option value="i">Immagine</option>
                            </select></td></tr>
						<tr><td>Anteprima:</td><td class="left"><input type="file" name="anteprima" accept="image/x-png,image/jpeg"></td></tr>
                        <tr><td colspan="2"><input type="submit"></td></tr>
                    </table>
                </form>
            </div>

        </main>

</body>

</html>