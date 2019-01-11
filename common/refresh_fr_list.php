<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $error="Errore nella connessione con il server";

    if(!(isset($_GET['action'])&&$_GET['next']&&isset($_SESSION['email'])&&!$error_connection['flag']))
        goto error;

    switch ($_GET['action']){

        #REFRESH DELLA TABELLA RICHIESTE PENDENTI
        case 'pending':
            $res=get_pending_request($_SESSION['email'],$_GET['next'],$connected_db);
            if(!$res)
                goto error;
            $users=array();
            #per ogni richiesta pendente
            while($row=$res->fetch_assoc()){
                #estraggo le informazioni su chi l'ha inviata
                $x=get_user_by_email($row['sender'],$connected_db);
                $y=$x->fetch_assoc();
                #verifico che la query non fallisca e trovi utenti validi
                if(!$x||!$y)
                    goto error;
                #metto nell'array degli utenti
                array_push($users,$y);
            }
            #stampo la tabella,vedi la funzione in display functions
            display_friendslist_rows($users,$_GET['next']+1,'pending',$connected_db);
            break;

        #REFRESH DELLA TABELLA DELLE AMICIZIE
        case 'friends':
            #prendo le amicizie correnti dalla tabella amicizia, vedi query in getter functions
            $res=get_friends($_SESSION['email'],0,$connected_db);
            #se la query fallisce log e redirect con segnalazione
            if(!$res)
                goto error;
            #verifico che effettivamente l'utente abbia amicizie correnti
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
                    if(!$x||!$y)
                        goto error;
                    
                    #metto nell'array degli utenti
                    array_push($users,$y);
                }
                #stampo la tabella,vedi la funzione in display functions
                display_friendslist_rows($users,1,'pending',$connected_db);
            }
            break;
    }
    
    exit();

    error:
        echo "<div class='error_div'><span class='error_span'>".$error."</span></div>";

?>