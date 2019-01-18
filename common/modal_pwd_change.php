<div id="modal_bg_3" class="modal_bg">
    <div class="modal_wrapper">
        <div class="closure_cross_container">
            <span class="closure_cross" onclick="document.getElementById('modal_bg_3').style.display='none'">&times</span>
        </div>
        <div class="modal_login">
            <div class="modal_group"><label for="pwd">Password attuale:</label></div>
            <div class="modal_group"><input type="password" class="modal_text" class='old_pwd' required></div>
            <div class="modal_group"><button class="modal_button" type="button" onclick="old_pwd_check(document.getElementsByClassName('old_pwd')[0].value)">Valida</button></div>
        </div>
        <div class="closure_cross_container"></div>
    </div>
</div>
<script>
    var el=document.getElementById("modal_bg_3")
    window.onclick=function(event){
        if(event.target==el)
            el.style.display='none'
    }

</script>