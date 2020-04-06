if(typeof showPassword != "undefined"){
    if(showPassword.checked){
        password.type = "text"
    }
    else{
        password.type = "password"
    }

    showPassword.onclick = function(){
        if(showPassword.checked){
            password.type = "text"
        }
        else{
            password.type = "password"
        }
    }
}

if(typeof showRepeatPassword != "undefined"){
    if(showRepeatPassword.checked){
        repeatPassword.type = "text"
    }
    else{
        repeatPassword.type = "password"
    }

    showRepeatPassword.onclick = function(){
        if(showRepeatPassword.checked){
            repeatPassword.type = "text"
        }
        else{
            repeatPassword.type = "password"
        }
    }
}
