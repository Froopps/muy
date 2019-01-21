var filters=[/^[A-Za-z0-9\?\.\+\^\[\]\'&~=_-èéàòù ]+@[A-Za-z0-9\?\.\+\^\'&~=_-èéàòù ]+\.{1}[A-Za-z]{2,6}$/,/^[A-Za-z\'èéàòù ]+$/,/^[A-Za-z0-9\'èéàòùì!?-_.:,; ]+$/]

function pattern_validation(input,filter,logoy,logon,logony){
    var reg=new RegExp(filters[filter])
    if(input.value==""){
        document.getElementById(logoy).setAttribute('style','display: none')
        document.getElementById(logon).setAttribute('style','display: none')
        document.getElementById(logony).setAttribute('style','display: block')
    }else if(reg.test(input.value)){
        document.getElementById(logoy).setAttribute('style','display: block')
        document.getElementById(logon).setAttribute('style','display: none')
        document.getElementById(logony).setAttribute('style','display: none')
    }else{
        document.getElementById(logoy).setAttribute('style','display: none')
        document.getElementById(logon).setAttribute('style','display: block')
        document.getElementById(logony).setAttribute('style','display: none')
    }
}

function pass_val(input,logoy,logon,logony){
    if(input.value==""){
        document.getElementById(logoy).setAttribute('style','display: none')
        document.getElementById(logon).setAttribute('style','display: none')
        document.getElementById(logony).setAttribute('style','display: block')
    }else if(input.value.length>=8){
        document.getElementById(logoy).setAttribute('style','display: block')
        document.getElementById(logon).setAttribute('style','display: none')
        document.getElementById(logony).setAttribute('style','display: none')
    }else{
        document.getElementById(logoy).setAttribute('style','display: none')
        document.getElementById(logon).setAttribute('style','display: block')
        document.getElementById(logony).setAttribute('style','display: none')
    }
}

function confirm_check(input,logoy,logon,logony){
    if(input.value==""||input.value==undefined){
        document.getElementById(logoy).setAttribute('style','display: none')
        document.getElementById(logon).setAttribute('style','display: none')
        document.getElementById(logony).setAttribute('style','display: block')
    }else if(input.value==document.getElementById("pwd_in_signup").value&&input.value.length>=8){
        document.getElementById(logoy).setAttribute('style','display: block')
        document.getElementById(logon).setAttribute('style','display: none')
        document.getElementById(logony).setAttribute('style','display: none')
    }else{
        document.getElementById(logoy).setAttribute('style','display: none')
        document.getElementById(logon).setAttribute('style','display: block')
        document.getElementById(logony).setAttribute('style','display: none')
    }
}

function check_date(input,logoy,logon,logony){
    var birthday=new Date(input.value)
    if(birthday<Date.now() && birthday>=new Date("1901-01-01")){
        document.getElementById(logoy).setAttribute('style','display: block')
        document.getElementById(logon).setAttribute('style','display: none')
        document.getElementById(logony).setAttribute('style','display: none')
    }else{
        document.getElementById(logoy).setAttribute('style','display: none')
        document.getElementById(logon).setAttribute('style','display: block')
        document.getElementById(logony).setAttribute('style','display: none')
    }
}
function old_pwd_check(input){
        var par="attribute=old_pwd&value="+input
        console.log('ya')
        xhr=open_xml_post("http://localhost/muy/backend/validate_new_info.php")
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                var error=xhr.responseXML.getElementsByTagName('error')[0]
                document.getElementById('modal_bg_3').style.display='none'
                if(error.getAttribute('triggered')=='true')
                    append_error_atop(error.childNodes[0].childNodes[0].nodeValue)
            }
        }
        xhr.send(par)
}

