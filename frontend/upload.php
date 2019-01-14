<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Upload</title>
    <link rel="stylesheet" href="../node_modules/croppie/croppie.css">
	
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
            if(isset($_GET["error"])){
                echo "<span class='error_span'>".$_GET["error"]."</span>";
            }
            if(isset($_GET["msg"])){
                echo "<span class='message_span'>".$_GET["msg"]."</span>";
            }
            ?>
            <div>
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
            <span>
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
                            <td class="left" colspan="2"><input type="file" name="anteprima" accept="image/*" onchange="crop_image(this,document.getElementById('croppie-box-img'),'no');document.getElementsByName('ante-line-img')[1].setAttribute('style','display: auto')"></td>
                        </tr>
                        <tr name="ante-line-img" style="display: none"><td colspan="3" id="crop-td"><img id='croppie-box-img' src='#' alt=''></td></tr>

                        <tr id="ante-line-auto" style="display: none">
                            <td>Anteprima:</td>
                            <td id="crop-td" colspan="2"><img id='croppie-box-auto' src='#' alt='Spiazènti'></td>
                        </tr>

                        <tr><td colspan="3"><input type="submit"></td></tr>
                    </table>
                </form>
            </span>
            <span>
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
            </span>
            <canvas id="prevImgCanvas">Il tuo browser non supporta il tag canvas di HTML5</canvas>
        </div>

    </main>
    <script type="text/javascript" src="../common/script/setup.js"></script>
    <script type="text/javascript" src="../common/script/_aux.js"></script>
    <script type="text/javascript" src="../node_modules/croppie/croppie.js"></script>
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
                    document.getElementById('ante-line-auto').setAttribute('style','display: none')
                    break
                case "video/":
                    document.getElementById('ante-line-auto').setAttribute('style','display: auto')
                    //croppieAnteprima(document.getElementById('prevImgCanvas'),document.getElementById('croppie-box-auto'))
                    document.getElementsByName('ante-line-img')[0].setAttribute('style','display: none')
                    document.getElementsByName('ante-line-img')[1].setAttribute('style','display: none')
                    break
                case "image/":
                    document.getElementById('ante-line-auto').setAttribute('style','display: auto')
                    crop_image(document.getElementById('inputf'),document.getElementById('croppie-box-auto'),'no')
                    document.getElementsByName('ante-line-img')[0].setAttribute('style','display: none')
                    document.getElementsByName('ante-line-img')[1].setAttribute('style','display: none')
                    break
            }
        }
        
        
        var video = document.createElement("video");

        var canvas = document.getElementById("prevImgCanvas");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        video.addEventListener('loadeddata', function() {
            reloadRandomFrame();
        }, false);

        video.addEventListener('seeked', function() {
            var context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
            console.log(canvas)
        }, false);

        var playSelectedFile = function(event) {
            var file = this.files[0];
            var fileURL = URL.createObjectURL(file);
            video.src = fileURL;
            canvas.toBlob(function(blob) {
              var newImg = document.createElement('img'),
                  url = URL.createObjectURL(blob);

              newImg.onload = function() {
                // no longer need to read the blob so it's revoked
                URL.revokeObjectURL(url);
              };

              newImg.src = url;
              document.body.appendChild(newImg);
                console.log(newImg)
            });
            //croppieAnteprima(newImg,document.getElementById('croppie-box-auto'))
        }

        var input = document.getElementById('inputf');
        input.addEventListener('change', playSelectedFile, false);

        function reloadRandomFrame() {
          if (!isNaN(video.duration)) {
            var rand = Math.round(Math.random() * video.duration * 1000) + 1;
            video.currentTime = rand / 1000;
          }
        }
    </script>

</body>

</html>