<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Signup</title>
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
                <form action="#signup_script" method="post">
                    <table id="signup-table">
                        <tr><td></td><td></td><td>Privato</td></tr>
                        <tr><td>e-Mail*:</td><td><input type="text" name="mail" placeholder="e-mail" required></td><td><input type="checkbox" name="mail-check"></td></tr>
                        <tr><td>Password*:</td><td><input type="password" name="pwd" required></td></tr>
                        <tr><td>Conferma Password*:</td><td><input type="password" name="pwd-c" required></td></tr>
                        <tr><td>Nome:</td><td><input type="text" name="nom" placeholder="Nome"></td><td><input type="checkbox" name="nom-check"></td></tr>
                        <tr><td>Cognome:</td><td><input type="text" name="cog" placeholder="Cognome"></td><td><input type="checkbox" name="cog-check"></td></tr>
                        <tr><td>Nickname:</td><td><input type="text" name="nick" placeholder="Nickname"></td><td><input type="checkbox" name="nick-check"></td></tr>
                        <tr><td>Data di nascita:</td><td><input type="date" name="dataNa"></td><td><input type="checkbox" name="date-check"></td></tr>
                        <tr><td>Sesso:</td><td class="left"><select name="sex">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select></td><td><input type="checkbox" name="sex-check"></td></tr>
                        <tr><td>Città:</td><td><input type="text" name="cit" placeholder="Città"></td><td><input type="checkbox" name="cit-check"></td></tr>
                        <tr><td>Immagine del profilo:</td><td><input type="file" name="pic" accept="image/x-png,image/jpeg"></td><td><input type="checkbox" name="pic-check"></td></tr>
                        <tr><td colspan="2"><input type="submit"></td></tr>
                    </table>
                </form>
            </div>

        </main>

</body>

</html>