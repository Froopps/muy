function suggestions_search(){
    var bar=document.getElementById('src')
    var type=document.getElementById('src_block').elements['src_type'].value
    var list=document.getElementsByClassName('sug_list')[0]
    var block=document.getElementsByClassName('sug_block')[0]
    if(bar.value.length<=1){
        list.style.display='none'
        list.style.display='none'
    }
    else{
        var xhr=ajaxRequest()
        xhr.open("GET","http://localhost/muy/backend/test.php?pattern="+bar.value+"&table="+type)
        xhr.responseType='text'
        list.style.display='flex'
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                document.getElementsByClassName('sug_list')[0].innerHTML=xhr.responseText
            }
        }
        xhr.send()
    }
}