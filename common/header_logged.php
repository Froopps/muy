<header>
    <a id="logo" href="../frontend/home.php">LOGO</a>
    <a id="primohsx" href="#upload">Upload</a>
    <!-- <a class="hsx" href="#contact">Contact</a> -->
    <form action="" method="get">
        <input id="srcbtn" type="submit">
        <input id="src" type="text" name="cerca" placeholder="Cerca...">
    </form>    
    <a class="hdx" href="../backend/esci.php">Esci</a>
    <?php
        echo "<a class='hdx' href='../frontend/user.php?user=".$_SESSION["email"]."'>".$_SESSION["nome"]."</a>";
    ?>
</header>