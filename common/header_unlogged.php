<header>
    <a id="logo" href="../frontend/home.php"></a>
    <form id="src_block" action="#src_results" method="get">
        <select name="src_type">
            <option value="v">Video</option>
            <option value="a">Audio</option>
            <option value="i">Immagine</option>
            <option value="u">Utente</option>
            <option value="c">Canale</option>
        </select>
        <input id="srcbtn" type="submit">
        <input id="src" type="text" name="src_txt" placeholder="Cerca...">
        <a id="avanzata" href="#ricerca_avanzata">Avanzata</a>
    </form>
    <span>
        <!---a href="../frontend/signup.php">Registrati</a--->
        <button class="button_text" onclick="document.getElementById('modal_bg_1').style.display='flex'">Login</button>
    </span>
</header>
<?php
    include_once "modal_login.php"
?>