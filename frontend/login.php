<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Login</title>
    
    <?php include "../common/head.html"; ?>
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