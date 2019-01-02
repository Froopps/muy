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
            include "../common/header_logged.php";
            include "../common/sidebar_logged.php";
        ?>

        <main>

            <div class="content">
                <form action="#upload_script" method="post">
                    <table id="signup-table">
                        <tr><td>Upload file:</td><td><input type="file" name="content" accept=""></td></tr>
                        <tr><td>Titolo:</td><td><input type="text" name="title" placeholder="Titolo" required></td></tr>
                        <tr><td>Descrizione:</td><td><textarea name="desc" placeholder="Descrizione" cols="41" rows="3"></textarea></td></tr>
                        <tr><td>Sesso:</td><td class="left"><select name="sex">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            </select></td></tr>
						<tr><td>Anteprima:</td><td><input type="file" name="anteprima" accept="image/x-png,image/jpeg"></td></tr>
                        <tr><td colspan="2"><input type="submit"></td></tr>
                    </table>
                </form>
            </div>

        </main>

</body>

</html>