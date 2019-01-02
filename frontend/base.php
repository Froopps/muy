<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Base</title>
    
    <?php include "../common/head.php"; ?>
</head>

<body>

    <?php 
        if(isset($_SESSION["email"])){
            include "../common/header_logged.php";
            include "../common/sidebar_logged.php";
        }else{
            include "../common/header_unlogged.php";
            include "../common/sidebar_unlogged.html";
        }
    ?>

        <main>
            <div class="content">
            </div>
        </main>

</body>

</html>