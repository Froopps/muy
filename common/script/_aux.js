
//crop_image(container(could be an img,div or something),input type file to retrieve the file selected,button for submission)
function crop_image(in_file,image,button){
    
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
                button.disable=true
                box.result('blob').then(function(blob){
                    sub(blob)
                })
            }
            function sub(img){
                var newF=new FormData()
                newF.append('cropped_pro_pic',img,'pro_pic')
                xhr=ajaxRequest()
                button.style.display='none'
                button.disabled=true
                //altough the name may let think differently, the function uploads content preview image too 
                xhr.open("POST","http://localhost/muy/backend/pro_pic_update.php",true)
                xhr.onreadystatechange=function(){
                    if(xhr.readyState==4 && xhr.status==200){
                        var error=xhr.responseXML.getElementsByTagName('error')[0]
                
                        if(error.getAttribute('triggered')=='true')
                            append_error_atop(error.childNodes[0].childNodes[0].nodeValue)
                        else{
                            button.innerHTML='ok'
                            button.style.display='inline-block'
                        }
                    }
                }
                xhr.send(newF)
            }
        }
        reader.readAsDataURL(in_file.files[0])
    }
}

//set the default foto
function set_def_foto(button){

    var par="default=1"
    xhr=ajaxRequest()
        xhr.open("POST","http://localhost/muy/backend/pro_pic_update.php",true)
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200)
                button.innerHTML="ok"
        }
        xhr.send(par)
}

function update_user_info(attribute,button){

        var par="attribute="+attribute.name+"&value="+attribute.value
         console.log(attribute.name,' ',attribute.value)
        xhr=ajaxRequest()
        xhr=open_xml_post("http://localhost/muy/backend/validate_new_info.php")
        button.style.display='none'
        button.disabled=true
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                
                console.log(xhr.response)
                var error=xhr.responseXML.getElementsByTagName('error')[0]
                
                if(error.getAttribute('triggered')=='true')
                    append_error_atop(error.childNodes[0].childNodes[0].nodeValue)
                else{
                    button.innerHTML="ok"
                    button.style.display='inline-block'
                }
            }
        }
        xhr.send(par)

}



function removeFile(input){
    document.getElementsByName(input)[0].value=""
}

