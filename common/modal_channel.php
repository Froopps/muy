<div id="modal_bg_2" class="modal_bg">
    <div class="modal_wrapper">
        <div class="closure_cross_container" >
            <span class="closure_cross" onclick="document.getElementById('modal_bg_2').style.display='none'">&times</span>
        </div>
        <form id="modal_login" method="post" action="../backend/new_channel.php">
            <?php
                echo "<input type='hidden' name='owner' value=".$_SESSION["email"].">";
            ?>
            <label for="channel_name">Nome Canale:</label>
            <input type="text" name="channel_name" required>
            <label for="label">Etichetta:</label>
            <input type="text" name="label" required>
            <select class="src_type sel_channel_vis" name="channel_type">
                <option value="public">Pubblico</option>
                <option value="private">Social</option>
                <option value="social">Privato</option>
            </select>
            <input type="submit" class="button_text" value="Crea">
        </form>
    </div>
</div>
<script>
    var el=document.getElementById("modal_bg_2")
    window.onclick=function(event){
        if(event.target==el)
            el.style.display='none'
    }
</script>