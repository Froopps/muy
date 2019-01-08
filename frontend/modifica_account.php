<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Top categories</title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>
    
        <!-- controllo loggato -->
        <?php 
            $redirect_with_error="Location: http://localhost/muy/frontend/signup.php?error=";
            if($error_connection["flag"]){
                $redirect_with_error.=urlencode($error_connection["msg"]);
                header($redirect_with_error);
                exit();
            }
            if(!isset($_SESSION["email"])){
                $redirect_with_error.="Autenticazione richiesta";
                header($redirect_with_error);
                $connected_db->close();
                exit();
            }
        ?>

        <main>
            <div class="content">
            </div>
        </main>
</body>