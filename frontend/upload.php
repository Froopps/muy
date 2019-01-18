<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Upload</title>
	
    <?php include "../common/head.php"; ?>
</head>

<body>

    <?php
        include "../common/header_logged.php";
        include "../common/sidebar_logged.php";
    ?>
    <main>
        <div class="content-centre">
        <?php
            $redirect_with_error="Location: http://localhost/muy/home.php?error=";
            if($error_connection["flag"]){
            $redirect_with_error.=urlencode($error_connection["msg"]);
                header($redirect_with_error);
                exit();
            }
            $query="SELECT nome FROM canale WHERE proprietario='".escape($_SESSION["email"],$connected_db);
            $query.="'";
            $res=$connected_db->query($query);
            if(!$res){
                $redirect_with_error.="Errore nella connessione con il database";
                log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                header($redirect_with_error);
                $connected_db->close();
                exit();
            }
            $no_channel=0;
            if($res->num_rows==0){
                $no_channel=1;
                echo "<span class='error_span'><button class=\"in_notext\" type=\"button\" onclick=\"document.getElementById('modal_bg_2').style.display='flex'\">Prima crea un canale</button></span></div>";
                echo "<div class=\"content-centre\" style=\"display: none\">";
            }
        ?>
        <?php
            if(isset($_GET["error"])){
                echo "<span class='error_span'>".$_GET["error"]."</span>";
            }
            if(isset($_GET["msg"])){
                echo "<span class='message_span'>".$_GET["msg"]."</span>";
            }
            ?>
            <div class="center">
                <table id="signup-table">
                    <tr>
                        <td>Cosa devi caricare?</td>
                        <td>
                            <select name="up-select" onchange="selectUpload(this,'up-file','up-youtube')">
                                <option value="f">File</option>
                                <option value="yt">Youtube</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <form enctype="multipart/form-data" action="../backend/upload.php" method="post" id="up-file" style="display: block">
                    <table id="signup-table">
                        <tr><th colspan="3">Upload File</th></tr>
                        <tr>
                            <td>Upload file:</td>
                            <td class="left">
                                <input type="hidden" name="MAX_FILE_SIZE" value="10000000000"/>
                                <input type="file" name="file" id="inputf" accept="audio/*,video/*,image/*" required onchange="showAnteprima(this)">
                            </td>
                            <td><button class="in_notext" type="button" onclick="removeFile()">Rimuovi</button></td>
                        </tr>
                        <tr>
                            <td>Canale:</td>
                            <td class="left" colspan="2">
                                <select name="channel" required>
                                    <?php
                                        while($row=$res->fetch_assoc()){
                                            echo "<option value=\"".$row["nome"]."\"";
                                            // se arrivi da user seleziona automaticamente il canale
                                            if(isset($_GET["canale"]) && $_GET["canale"]==$row["nome"]){
                                                echo " selected";
                                            }
                                            echo ">".stripslashes($row["nome"])."</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr><td>Titolo:</td><td class="left" colspan="2"><input type="text" name="title" placeholder="Titolo" required></td></tr>
                        <tr><td>Descrizione:</td><td class="left" colspan="2"><textarea name="desc" placeholder="Descrizione" cols="54" rows="3"></textarea></td></tr>
                        <tr><td>Etichette:</td><td class="left" colspan="2"><textarea name="tag" placeholder="Inserisci le etichette precedute da #&#10;Esempio: #mare #montagna" cols="54" rows="3"></textarea></td></tr>

                        <tr name="ante-line-img" style="display: none">
                            <td>Anteprima:</td>
                            <td class="left" colspan="2"><input type="file" name="anteprima" accept="image/*"></td>
                        </tr>

                        <tr><td colspan="3"><input type="submit"></td></tr>
                    </table>
                </form>
            </div>
            <div>
                <form enctype="multipart/form-data" action="../backend/upload_yt.php" method="post" id="up-youtube" style="display: none">
                    <table id="signup-table">
                        <tr><th colspan="2">Upload Youtube</th></tr>
                        <tr><td>URL:</td><td class="left"><input type="text" name="url" placeholder="https://www.youtube.com/watch?..." required></td></tr>
                        <tr><td>Canale:</td><td class="left">
                            <select name="channel" required>
                                <?php
                                $redirect_with_error="Location: http://localhost/muy/home.php?error=";
                                if($error_connection["flag"]){
                                    $redirect_with_error.=urlencode($error_connection["msg"]);
                                    header($redirect_with_error);
                                    exit();
                                }
                                $query="SELECT nome FROM canale WHERE proprietario='".escape($_SESSION["email"],$connected_db);
                                $query.="'";
                                $res=$connected_db->query($query);
                                if(!$res){
                                    $redirect_with_error.=urlencode("Errore nella connessione con il database");
                                    log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                                    header($redirect_with_error);
                                    $connected_db->close();
                                    exit();
                                }
                                while($row=$res->fetch_assoc()){
                                    echo "<option value=\"".$row["nome"]."\"";
                                    // se arrivi da user seleziona automaticamente il canale
                                    if(isset($_GET["canale"]) && $_GET["canale"]==$row["nome"]){
                                        echo " selected";
                                    }
                                    echo ">".stripslashes($row["nome"])."</option>";
                                }
                                $connected_db->close();
                                ?>
                            </select></td></tr>
                        <tr><td colspan="2"><input type="submit"></td></tr>
                    </table>
                </form>
            </div>
        </div>
        <?php
            if($no_channel)
                echo "</div>";
        ?>

    </main>
    <script type="text/javascript" src="../common/script/setup.js"></script>
    <script type="text/javascript" src="../common/script/_aux.js"></script>
    <script>
        function removeFile(){
            document.getElementsByName('file')[0].value=""
            document.getElementById('ante-line-auto').setAttribute('style','display: none')
            document.getElementsByName('ante-line-img')[0].setAttribute('style','display: none')
            document.getElementsByName('ante-line-img')[1].setAttribute('style','display: none')
        }
        
        function selectUpload(input,fform,yform){
            if(input.value=="f"){
                document.getElementById(fform).setAttribute('style','display: block')
                document.getElementById(yform).setAttribute('style','display: none')
            }else{
                document.getElementById(fform).setAttribute('style','display: none')
                document.getElementById(yform).setAttribute('style','display: block')
            }
        }

        function showAnteprima(file){
            //controllo se c'è files[0]
            tipo=file.files[0].type.substring(0,6)
            switch (tipo){
                case "audio/":
                    document.getElementsByName('ante-line-img')[0].setAttribute('style','display: auto')
                    break
                case "video/":
                    document.getElementsByName('ante-line-img')[0].setAttribute('style','display: none')
                    break
                case "image/":
                    document.getElementsByName('ante-line-img')[0].setAttribute('style','display: none')
                    break
            }
        }
    </script>
    <script type="text/javascript" src="../common/script/search.js"></script>
    <script type="text/javascript" src="../common/script/setup.js"></script>

</body>

</html>