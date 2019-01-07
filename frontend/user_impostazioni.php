<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    $redirect_with_error="Location: http://localhost/muy/home.php?error=";
        if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        header($redirect_with_error);
        exit();
    }
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>MyUNIMIYoutube | Impostazioni</title>
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
            <div class="headingArea">
                <h2>Aggiorna</h1>
            </div>
            <div class="user_impo_container">
                    <?php
                        
                        $res=get_user_by_email($_SESSION["email"],$connected_db);
                        if(!$res){
                            $redirect_with_error.="Errore nella connessione con il database";
                            log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                            header($redirect_with_error);
                            $connected_db->close();
                            exit();
                        }
                        $row=$res->fetch_assoc();
                        $types=array();

                    ?>
                <table class="signup-table">
                        <tr><td><input type="file" accept="image/png,image/jpeg" onchange="crop_image(this,document.getElementById('croppie_box'),'peppiniello',document.getElementById('crop_button'))"><td><td><button id="crop_button" type="button">Bella</button></td></tr>
                        <tr><td><img id="croppie_box" src="#" alt="Spiazènti"></td></tr>
                </table>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="../common/script/_aux.js"></script>
    <script type="text/javascript" src="../node_modules/croppie/croppie.js"></script>
</body>
