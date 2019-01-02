<?php
    session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>MyUNIMIYoutube | Registrazione</title>
	
    <?php include "../common/head.php"; ?>
</head>

<body>

        <?php
            include "../common/header_unlogged.php";
            include "../common/sidebar_unlogged.html";
        ?>

        <main>
            <script type="text/javascript" src="../common/script/user_info_validation.js"></script>
            <div class="content">
                <?php
                    if(isset($_GET["error"])){
                        #edit span to achieve a fashion error displaying
                        echo "<span class='error_span'>".$_GET["error"]."</span>";
                    }
                ?>
                <form action="../backend/signup.php" method="post">
                    <table id="signup-table">
                        <tr><td></td><td></td><td>Nascondi</td></tr>
                        <tr><td>e-Mail*:</td><td><input type="text" name="mail" placeholder="e-mail" required onkeyup="pattern_validation(this,0)"></td><td><input type="checkbox" name="check_list[]" value="email"></td></tr>
                        <tr><td>Password*:</td><td><input id="pwd_in_signup" type="password" name="pwd" required onchange="confirm_check(document.getElementById('pwd_conf'))" onkeydown="pass_val(this)"></td></tr>
                        <tr><td>Conferma Password*:</td><td><input id="pwd_conf" type="password" name="pwd-c" onblur="confirm_check(this)"required></td></tr>
                        <tr><td>Nome*:</td><td><input type="text" name="nom" placeholder="Nome" required onkeyup="pattern_validation(this,1)"></td><td><input type="checkbox" name="check_list[]" value="nome"></td></tr>
                        <tr><td>Cognome*:</td><td><input type="text" name="cog" placeholder="Cognome" required onkeyup="pattern_validation(this,1)"></td><td><input type="checkbox" name="check_list[]" value="cognome"></td></tr>
                        <tr><td>Nickname:</td><td><input type="text" name="nick" placeholder="Nickname"></td></tr>
                        <tr><td>Data di nascita*:</td><td><input type="date" name="dataNa" required onblur="check_date(this)"></td><td><input type="checkbox" name="check_list[]" value="dataNascita"></td></tr>
                        <tr><td>Sesso:</td><td class="left"><select name="sex">
                            <option value="Maschio">Male</option>
                            <option value="Femmina">Female</option>
                        </select></td><td><input type="checkbox" name="check_list[]" value="sesso"></td></tr>
                        <tr><td>Città:</td><td><input type="text" name="cit" placeholder="Città" onkeyup="pattern_validation(this,1)"></td><td><input type="checkbox" name="check_list[]" value="città"></td></tr>
                        <tr><td colspan="2"><input type="submit"></td></tr>
                    </table>
                </form>
            </div>

        </main>

</body>

</html>