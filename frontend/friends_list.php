<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
    $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=";
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        header($redirect_with_error);
        exit();
    }
    if(!isset($_SESSION["email"])){
        $rediret_with_error.=urlencode("Accesso negato");
        header($redirect_with_error);
        exit();
    }

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>MyUNIMIYoutube | Amici</title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>
    <?php
        include "../common/header_logged.php";
        include "../common/sidebar_logged.php";
    ?>
    <div class="content">
        <div class="headingArea">
            <h2>Richieste</h2>
        </div>
        <div class="friend_list_tb pending_view">
        <?php
            #prendo le richieste pendenti dalla tabella amicizia, vedi query in getter functions
            $res=get_pending_request($_SESSION['email'],0,$connected_db);
            #se la query fallisce log e redirect con segnalazione
            if(!$res){
                $redirect_with_error.="Errore nella connessione con il server";
                header($redirect_with_error);
                exit();
            }
            #verifico che effettivamente l'utente abbia richieste pendenti
            if($res->num_rows==0)
                echo "<div class='error_div'><span class='message_span'>Nessuna richiesta in attesa di conferma</span></div>";
            else{
                $users=array();
                #per ogni richiesta pendente
                while($row=$res->fetch_assoc()){
                    #estraggo le informazioni su chi l'ha inviata
                    $x=get_user_by_email($row['sender'],$connected_db);
                    $y=$x->fetch_assoc();
                    #verifico che la query non fallisca e trovi utenti validi
                    if(!$x||!$y){
                        $redirect_with_error.="Errore nella connessione con il server";
                        header($redirect_with_error);
                        exit();
                    }
                    #metto nell'array degli utenti
                    array_push($users,$y);
                }
                #stampo la tabella,vedi la funzione in display functions
                display_friendslist_rows($users,1,'pending',$connected_db);
            }
        ?>
        </div>
        <div class="headingArea">
            <h2 style='margin-top:30px;'>Amici</h2>
        </div>
        <div class="friend_list_tb friends_view">
        <?php
            #prendo le amicizie correnti dalla tabella amicizia, vedi query in getter functions
            $res=get_friends($_SESSION['email'],0,$connected_db);
            #se la query fallisce log e redirect con segnalazione
            if(!$res){
                $redirect_with_error.="Errore nella connessione con il server";
                header($redirect_with_error);
                exit();
            }
            #verifico che effettivamente l'utente abbia ramicizie correnti
            if($res->num_rows==0)
                echo "<div class='error_div'><span class='message_span'>Nessuna richiesta in attesa di conferma</span></div>";
            else{
                $users=array();
                #per ogni amicizia corrente
                while($row=$res->fetch_assoc()){
                    #estraggo le informazioni dell'altro utente coinvolto nell'amicizia
                    $x=$row['receiver']==$_SESSION['email'] ? get_user_by_email($row['sender'],$connected_db):get_user_by_email($row['receiver'],$connected_db);
                    $y=$x->fetch_assoc();
                    #verifico che la query non fallisca e trovi utenti validi
                    if(!$x||!$y){
                        $redirect_with_error.="Errore nella connessione con il server";
                        header($redirect_with_error);
                        exit();
                    }
                    #metto nell'array degli utenti
                    array_push($users,$y);
                }
                #stampo la tabella,vedi la funzione in display functions
                display_friendslist_rows($users,1,'friends',$connected_db);
            }
        ?>
        </div>
    </div>
    <script type='text/javascript' src='../common/script/friendship.js'></script>
    <script type='text/javascript' src='../common/script/setup.js'></script> 
</body>
</html>