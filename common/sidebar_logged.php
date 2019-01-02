<?php
    include_once "modal_channel.php"
?>
<nav>
    <input type="checkbox" id="nav-toggle" hidden>
    <label for="nav-toggle" class="burger">
        <!-- logo hamburger -->
        <div class="ham"></div>
        <div class="ham"></div>
        <div class="ham"></div>
    </label>
    <span id="nasc">
    <ul>
        <li><a href="../frontend/home.php">Home</a></li>
        <li class="no_link">Display<hr></li>
        <li><a href="../frontend/home.php">Top visited</a></li><!--QUESTIONE HOME-->
        <li><a href="../frontend/top-users.php">Top users</a></li>
        <li><a href="../frontend/top-categories.php">Top categories</a></li>
        <li><a href="../frontend/etichette.php">Etichette</a></li>
        <li class="no_link">Account<hr></li>
        <li><a href="#notifiche">Notifiche</a></li>
        <li><a href="#amici">Amici</a></li>
        <!---return required. If the function return false the onclick event will be aborted. Deafault <a> behaviour --->
        <li><a href="#nuovo" onclick="document.getElementById('modal_bg_2').style.display='flex'">Nuovo Canale</a></li>
        <li><a href="#stats">Statistiche</a></li>
        <li><a href="#xyz">Impostazioni</a></li>
        <li class="no_link">About<hr></li>
        <li><a href="#xyz">Chi siamo</a></li>
    </ul>
    </span>
</nav>