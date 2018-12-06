<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Base</title>
    
    <?php include "../common/head.html"; ?>
</head>

<body>
    
        <!-- controllo loggato -->
        <?php 
            if(isset($_SESSION["logged"])){
                if($_SESSION["logged"]){
                    include "../common/header_logged.html";
                    include "../common/sidebar_logged.html";
                }else{
                    include "../common/header_unlogged.html";
                    include "../common/sidebar_unlogged.html";
                }
            }else{
                include "../common/header_unlogged.html";
                include "../common/sidebar_unlogged.html";
            }
        ?>

        <main>
            <div class="content">
            </div>
        </main>

</body>

</html>