<?php
    include_once "modal_channel.php"
?>
<nav>
    <input type="checkbox" id="nav-toggle" hidden>
    <label for="nav-toggle" class="burger">
    <!--<label class="burger" onclick="hide()">-->
        <!-- logo hamburger -->
        <div class="ham"></div>
        <div class="ham"></div>
        <div class="ham"></div>
    </label>
    <span id="nasc">
    <!--<span id="nasc" style="left: -300px">-->
    <ul>
        <li><a href="../frontend/home.php">Home</a></li>
        <li class="no_link">Display<hr></li>
        <li><a href="../frontend/home.php">Top visited</a></li>
        <li><a href="../frontend/top-users.php">Top users</a></li>
        <li><a href="../frontend/top-categories.php">Top categories</a></li>
        <li><a href="../frontend/etichette.php">Etichette</a></li>
        <li class="no_link">Account<hr></li>
        <li><a href="../frontend/friends_list.php">Amici</a></li>
        <!-- return required. If the function return false the onclick event will be aborted. Deafault <a> behaviour -->
        <li><a href="#nuovo" onclick="document.getElementById('modal_bg_2').style.display='flex'">Nuovo Canale</a></li>
        <li><a href="#stats">Statistiche</a></li>
        <li><a href="../frontend/user_impostazioni.php">Impostazioni</a></li>
        <li class="no_link">About<hr></li>
        <li><a href="#xyz">Chi siamo</a></li>
    </ul>
    </span>
</nav>

<script>
    function hide() {
        /*
        var bar = document.getElementById("nasc")
        var cont = document.getElementsByClassName("content")[0]
        var style = getComputedStyle(bar)
        */
        var s = document.styleSheets[0]

        for(var i = 0; i < s.cssRules.length; i++) {
            var rule = s.cssRules[i];
            if(rule.selectorText === "#nasc") {
                if(rule.style.display!="none")
                    rule.style.display = "none"
                else
                    rule.style.display = "block"
                return;
            }
        }
        /*
        if (bar.style.left=="0px") {
            bar.style.left = "-300px"
            cont.style.transform = "translateX(-200px)"
        }else{
            bar.style.left = "0"
            cont.style.transform = "translateX(0px)"
        }
        */
    }
</script>