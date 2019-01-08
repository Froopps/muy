function ajaxRequest(){
    var request=false;
    try{request=new XMLHttpRequest()}
    catch(e1){
        try{request=new ActiveXObject("Msxml2.XMLHTTP")}
        catch(e2){
            try{request=new ActiveXObject("Microsoft.XMLHTTP")}
            catch(e3){request=false}
        }
    }
    return request
}

//crop_image(container(could be an img,div or something),input type file to retrieve the file selected,button for submission and the original form)
function crop_image(in_file,image,user,button){
    if(in_file.files && in_file.files[0]){
        var reader=new FileReader()
        reader.onload=function(event){
            var box=new Croppie(image,{
                viewport:{width:100, height:100},
                boundary: {width:200, height:200}
            })
            var url_read=event.target.result
            box.bind({
                url: url_read
            })
            
            button.onclick=submit_with_crop
            function submit_with_crop(){
                button.innerHTML="Uploading..."
                button.disable=true
                box.result('blob').then(function(blob){
                    sub(blob)
                })
            }
            function sub(img){
                console.log(user)
                var newF=new FormData()
                newF.append('cropped_pro_pic',img,'pro_pic')
                newF.append('user',user)
                xhr=ajaxRequest()
                xhr.open("POST","http://localhost/muy/backend/pro_pic_update.php",true)
                xhr.onreadystatechange=function(){
                    if(xhr.readyState && xhr.status==200){
                        button.innerHTML="ok"
                    }
                }
                xhr.send(newF)
            }
        }
        reader.readAsDataURL(in_file.files[0])
    }
}

//set the default foto
function set_def_foto(user,button){

    var par="default=1&user="+user
    xhr=ajaxRequest()
        xhr.open("POST","http://localhost/muy/backend/pro_pic_update.php",true)
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                button.innerHTML="ok"
            }
        }
        xhr.send(par)
}

function update_user_info(user,attribute){

    var par=attribute.name+"="+attribute.value+"=&user="+user
    xhr=ajaxRequest()
        xhr.open("GET","http://localhost/muy/backend/test.php?"+par,true)
        xhr.responseType='document'
        xhr.overrideMimeType('application/xml')
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                //button.innerHTML="ok"
                
                var error=xhr.responseXML.getElementsByTagName('error')[0]
                
                if(error.getAttribute('triggered')=='true'){
                    var newErSpan=document.createElement('span')
                    newErSpan.setAttribute('class','error_span')
                    newErSpan.appendChild(document.createTextNode(error.childNodes[0].childNodes[0].nodeValue))
                    document.getElementsByClassName('user_impo_container').firstChild=newErSpan
                }
            }
        }
        xhr.send()

}