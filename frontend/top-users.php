<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");

    $redirect_with_error="Location: http://localhost/muy/frontend/home.php?error=";
    if($error_connection["flag"]){
        $redirect_with_error.=urlencode($error_connection["msg"]);
        header($redirect_with_error);
        exit();
        
    }
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MUY | Top users</title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>
    
        <!-- controllo loggato -->
        <?php 
            if(isset($_SESSION["email"])){
                include "../common/header_logged.php";
                include "../common/sidebar_logged.php";
            }
            else{
                include "../common/header_unlogged.php";
                include "../common/sidebar_unlogged.html";
            }
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
                <table id="classifica_usr">
                    <?php
                        $res=get_top_vip($connected_db);
                        if(!$res)
                            echo "<span class='error_span'>Errore nella connessione al server</span>";
                        else{
                            $b=true;
                            if($res->num_rows==0){
                                echo "<span class='message_span'>Non ci sono utenti top users al momento</span>";
                                $b=false;
                            }
                            for($i=0;$i<5&&$b;$i++){
                                echo "<tr>";
                                for($j=0;$j<2;$j++){
                                    if(!$row=$res->fetch_row()){
                                        $b=false;
                                        break;
                                    }
                                    echo "<td class='tab_top_usr'>";
                                    $res=get_user_by_email($row[0],$connected_db);
    
                                    if(!$res){
                                        echo "<span class='error_span'>Errore nella connessione al server</span>";
                                    }
                                    display_user_info($res->fetch_assoc(),$connected_db);
                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                        }
                    ?>
                    
                </table>
            </div>
        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
        <script type="text/javascript" src="../common/script/setup.js"></script>
</body>

</html>