<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Top users</title>
    
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
                    <tr>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                        <td class="tab_top_usr"><?php include "../common/user_info.html"; ?></td>
                    </tr>
                </table>
            </div>
        </main>

</body>

</html>