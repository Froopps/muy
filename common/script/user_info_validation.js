var filters=[/^[A-Za-z0-9\?\.\+\^\[\]\'&~=_-èéàòù ]+@[A-Za-z0-9\?\.\+\^\'&~=_-èéàòù ]+\.{1}[A-Za-z]{2,6}$/,/^[A-Za-zèéàòù ]+$/]

function pattern_validation(input,filter){
    var reg=new RegExp(filters[filter])
    if(reg.test(input.value))
        input.style.backgroundColor="rgba(79, 236, 205, 0.7)"
    else
        input.style.backgroundColor="rgba(212, 57, 57,0.4)"
}

function pass_val(input){
    if(input.value.length>=8)
        input.style.backgroundColor="rgba(79, 236, 205, 0.7)"
    else
        input.style.backgroundColor="rgba(212, 57, 57,0.4)"
}

function confirm_check(input){
    if(input.value==document.getElementById("pwd_in_signup").value)
        input.style.backgroundColor="rgba(79, 236, 205, 0.7)"
    else
        input.style.backgroundColor="rgba(212, 57, 57,0.4)"
}

function check_date(input){
    var birthday=new Date(input.value)
    if(birthday<Date.now() && birthday>=new Date("1901-01-01"))
        input.style.backgroundColor="rgba(79, 236, 205, 0.7)"
    else
        input.style.backgroundColor="rgba(212, 57, 57,0.4)"
}
