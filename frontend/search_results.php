<?php
    session_start();
    include_once realpath($_SERVER["DOCUMENT_ROOT"]."/muy/common/setup.php");
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Base</title>
    <link rel="stylesheet" href="../node_modules/croppie/croppie.css">
    
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

        <main class='search_page'>
            <div class="content">
                <?php
                    if(isset($_GET["error"])){
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                    if(isset($_GET["msg"])){
                        echo "<span class='message_span'>".$_GET["msg"]."</span>";
                    }
                ?>
                    <?php
                        $res=get_user_by_email($_SESSION['email'],$connected_db);
                        $row=$res->fetch_assoc();
                        $pro_pic=$_SERVER["DOCUMENT_ROOT"]."/../muy_res";
                        $pro_pic="data:image/png;base64,".base64_encode(file_get_contents($pro_pic."/".stripslashes($row["foto"])));
                        $pro_pic_alt="Spiacenti foto non trovata";
                    ?>
                    <ul class='search_results'>
                        <li class='search_results_entry'>
                        <?php
                        echo "<img class='propic' src='$pro_pic' alt=$pro_pic_alt>";
                        ?>
                        </li>
            </div>
        </main>
        <script type="text/javascript" src="../common/script/search.js"></script>
        <script type="text/javascript" src="../common/script/setup.js"></script>
</body>

</html>