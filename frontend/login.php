<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Login</title>
	<!-- Mio CSS -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../sources/images/icon.gif" rel="icon" type="image/gif">
	<link rel="stylesheet" type="text/css" href="../css/my.css"/>
</head>

<body>

        <?php
            include "../common/header_unlogged.html";
            include "../common/sidebar_unlogged.html";
        ?>

        <main>

            <div class="content">
                <form action="../backend/login-check.php" method="post">
                    <?php
                        if(isset($_SESSION["logged"])){
                            if(!($_SESSION["logged"])){
                                echo "Errore di login, riprova<br>";
                                $_SESSION["logged"]=NULL;
                            }
                        }
                    ?>
                    Login: <input type="text" name="login" default="Froops"><br>
                    Password: <input type="password" name="pwd" default="abc"><br>
                    <input type="submit">
                </form>
            </div>

        </main>

</body>

</html>