function showPassword() {
    var show_password=$("#exampleInputPassword")[0].type;
    if(show_password=="password"){
        $("#show_password")[0].innerHTML="<path d='M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z'/>";
        $("#exampleInputPassword")[0].type="text";
        $("#exampleRepeatPassword")[0].type="text";
    }
    else{
        $("#show_password")[0].innerHTML="<path d='M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z'/>";
        $("#exampleInputPassword")[0].type="password";
        $("#exampleRepeatPassword")[0].type="password";
    }
}