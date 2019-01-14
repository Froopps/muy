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

function open_xml_post(script){
    xhr=ajaxRequest()
    xhr.open("POST",script)
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhr.responseType='document'
    xhr.overrideMimeType('application/xml')
    return xhr
}

function append_error_atop(value){
    var newErSpan=document.createElement('span')
    var container=document.getElementsByClassName('content')[0]
    if(container.firstChild.className=='error_span')
        document.getElementsByClassName('error_span')[0].remove()
    newErSpan.setAttribute('class','error_span')
    newErSpan.appendChild(document.createTextNode(value))
    container.insertBefore(newErSpan,container.firstChild)
}