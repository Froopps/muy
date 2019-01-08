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
            <?php
                if(isset($_GET["error"])){
                    echo "<span class='error_span'>".$_GET["error"]."</span>";
                }
                if(isset($_GET["msg"])){
                    echo "<span class='message_span'>".$_GET["msg"]."</span>";
                }
            ?>
            <div class="headingArea">
                <h2>Aggiorna</h2>
            </div>
            <div class="user_impo_container">
            <table class="signup-table impo_table">
                    <?php
                        
                        $res=get_user_by_email($_SESSION["email"],$connected_db);
                        if(!$res){
                            $redirect_with_error.=urlencode("Errore nella connessione con il database");
                            log_into("Errore di esecuzione della query".$query." ".$connected_db->error);
                            header($redirect_with_error);
                            $connected_db->close();
                            exit();
                        }
                        $row=$res->fetch_assoc();
                        //echo "<tr><td><input type='file' accept='image/png,image/jpeg' onchange=\"crop_image(this,document.getElementById('croppie_box'),'".$_SESSION["email"]."',document.getElementById('crop_button'))\"></td><td><button id='crop_button' class='in_notext' type='button'>Aggiorna</button></td><td><button type='button' class='in_notext' onclick=\"set_def_foto('".$_SESSION["email"]."',this)\">Elimina</button></td></tr>";
                    
                    ?>
                    <tr class='heading_in_table'><td><h4>Email</h4></td></td>
                    <tr>
                        <td><input class='in_email_up' type="text" name='email' value='<?php echo $row['email'];?>'></td>
                        <td></td>
                        <td><button id='crop_button' class='in_notext' type='button' onclick="update_user_info('<?php echo $_SESSION['email'];?>',document.getElementsByClassName('in_email_up')[0])">Aggiorna</button></td>
                    </tr>
                    <tr class='heading_in_table'><td><h4>Nome</h4></td></td>
                    <tr>
                        <td><input type="text" value='<?php echo $row['nome'];?>'></td>
                        <td></td>
                        <td><button id='crop_button' class='in_notext' type='button'>Aggiorna</button></td>
                    </tr>
                    <tr class='heading_in_table'><td><h4>Cognome</h4></td></td>
                    <tr>
                        <td><input type="text" value='<?php echo $row['cognome'];?>'></td>
                        <td></td>
                        <td><button id='crop_button' class='in_notext' type='button'>Aggiorna</button></td>
                    </tr>
                    <tr class='heading_in_table'><td><h4>Nickname</h2><td><tr>
                    <tr>
                        <td><input type="text" value='<?php echo $row['nickname'];?>'></td>
                        <td></td>
                        <td><button id='crop_button' class='in_notext' type='button'>Aggiorna</button></td>
                    </tr>
                    <tr class='heading_in_table'><td><h4>Foto profilo</h2><td><tr>
                    <tr>
                        <td><input type='file' accept='image/png,image/jpeg' onchange="crop_image(this,document.getElementById('croppie_box'),'<?php echo $_SESSION['email'];?>',document.getElementById('crop_button'))"></td>
                        <td><button type='button' class='in_notext' onclick="set_def_foto('<?php echo $_SESSION['email'];?>',this)">Elimina</button></td>
                        <td><button id='crop_button' class='in_notext' type='button'>Aggiorna</button></td>
                    </tr>
                    <tr><td><img id='croppie_box' src='#' alt='Spiazènti'></td><tr>
                </table>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="../common/script/_aux.js"></script>
    <script type="text/javascript" src="../node_modules/croppie/croppie.js"></script>
</body>
