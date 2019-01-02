<div id="modal_bg_1" class="modal_bg">
    <div class="modal_wrapper">
        <div class="closure_cross_container" >
            <span class="closure_cross" onclick="document.getElementById('modal_bg_1').style.display='none'">&times</span>
        </div>
        <form id="modal_login" method="post" action="../backend/login-check.php">
            <label for="login">Username:</label>
            <input type="text" name="login" required>
            <label for="pwd">Password:</label>
            <input type="password" name="pwd" required>
            <input type="submit" class="button_text" value="Sign in">
        </form>
        <div class="modal_login_footer_bar">
            <a href="../frontend/signup.php">Registrati</a>
        </div>
    </div>
</div>
<script>
    var el=document.getElementById("modal_bg_1")
    window.onclick=function(event){
        if(event.target==el)
            el.style.display='none'
    }
</script>