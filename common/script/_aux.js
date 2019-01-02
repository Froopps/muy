function modal_close(el){
    window.onclick=function(event){
        if(event.target==el){
            el.style.display='none'
        }
    }
}