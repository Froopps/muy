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
                /*var newF=new FormData()
                newF.append('cropped_pro_pic',img,'pro_pic')
                newF.append('user',html_form.elements["mail"])
                xhr=ajaxRequest()
                xhr.open("POST","http://localhost/muy/backend/test.php",true)
                xhr.onload=function(){
                    if(xhr.status==200){
                        sub_form_inscope()
                    }
                    else{
                        console.log(xhr.response)
                    }
                }
                xhr.send(newF)
            }
            function sub_form_inscope(){
                html_form.submit()*/
            }
        }
        reader.readAsDataURL(in_file.files[0])
    }
}