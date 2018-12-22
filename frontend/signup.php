<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Registrazione</title>
	
    <?php include "../common/head.html"; ?>
</head>

<body>

        <?php
            include "../common/header_unlogged.html";
            include "../common/sidebar_unlogged.html";
        ?>

        <main>

            <div class="content">
                <?php
                    if(isset($_GET["error"])){
                        #edit span to achieve a fashion error displaying
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                ?>
                <form action="../backend/signup.php" method="post">
                    <table id="signup-table">
                        <tr><td></td><td></td><td>Privato</td></tr>
                        <tr><td>e-Mail*:</td><td><input type="text" name="mail" placeholder="e-mail" required></td><td><input type="checkbox" name="check_list[]" value="email"></td></tr>
                        <tr><td>Password*:</td><td><input type="password" name="pwd" required></td></tr>
                        <tr><td>Conferma Password*:</td><td><input type="password" name="pwd-c" required></td></tr>
                        <tr><td>Nome*:</td><td><input type="text" name="nom" placeholder="Nome" required></td><td><input type="checkbox" name="check_list[]" value="nome"></td></tr>
                        <tr><td>Cognome*:</td><td><input type="text" name="cog" placeholder="Cognome" required></td><td><input type="checkbox" name="check_list[]" value="cognome"></td></tr>
                        <tr><td>Nickname:</td><td><input type="text" name="nick" placeholder="Nickname"></td><td><input type="checkbox" name="check_list[]" value="nickname"></td></tr>
                        <tr><td>Data di nascita*:</td><td><input type="date" name="dataNa" required></td><td><input type="checkbox" name="check_list[]" value="dataNascita"></td></tr>
                        <tr><td>Sesso:</td><td class="left"><select name="sex">
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                        </select></td><td><input type="checkbox" name="check_list[]" value="sesso"></td></tr>
                        <tr><td>Città:</td><td><input type="text" name="cit" placeholder="Città"></td><td><input type="checkbox" name="check_list[]" value="città"></td></tr>
                        <tr><td>Immagine del profilo:</td><td><input type="file" name="pic" accept="image/x-png,image/jpeg"></td><td><input type="checkbox" name="check_list[]" value="foto"></td></tr>
                        <tr><td colspan="2"><input type="submit"></td></tr>
                    </table>
                </form>
            </div>

        </main>

</body>

</html>