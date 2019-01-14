<div id="modal_bg_3" class="modal_bg">
    <div class="modal_wrapper">
        <div class="closure_cross_container" >
            <span class="closure_cross" onclick="document.getElementById('modal_bg_3').style.display='none'">&times</span>
        </div>
        <div class="modal_login">
            <label for="pwd">Password attuale:</label>
            <input type="password" class='old_pwd' required>
            <button type="button" class="button_text" onclick="old_pwd_check(document.getElementsByClassName('old_pwd')[0].value)">Valida</button>
        </div>
    </div>
</div>
<script>
    var el=document.getElementById("modal_bg_3")
    window.onclick=function(event){
        if(event.target==el)
            el.style.display='none'
    }

</script>