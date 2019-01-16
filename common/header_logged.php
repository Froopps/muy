<header>
    <span>
        <a id="logo" href="../frontend/home.php"></a>
        <a id="primo" href="../frontend/upload.php">Upload</a>
    </span>
    <form id="src_block" action="#src_results" method="get">
        <select name="src_type">
            <option value="oggettoMultimediale">Contenuto</option>
            <option value="utente">Utente</option>
            <option value="canale">Canale</option>
            <option value="categoria">Tag</option>
        </select>
        <input id="srcbtn" type="submit">
        <div class='src_suggestion_container'>
            <input id="src" type="text" name="src_txt" placeholder="Cerca..." onchange="suggestions_search()">
            <div class='sug_list'></div>
        </div>
        <a id="avanzata" href="#ricerca_avanzata">Avanzata</a>
    </form>
    <span>
        <?php
            echo "<a href='../frontend/user.php?user=".htmlentities(urlencode($_SESSION["email"]))."'>".$_SESSION["nome"]."</a>";
        ?>
        <a href="../backend/esci.php">Esci</a>
    </span>
</header>