function frmLogin(e){
    e.preventDefault();
    const usuario = document.getElementById("user");
    const clave = document.getElementById("pass");
    let contenedoruser = document.getElementById("contuser")
    let contenedorpass = document.getElementById("contpass")
    if(usuario.value == ""){
        contenedorpass.classList.remove("is-invalid");
        contenedoruser.classList.add("is-invalid");
        usuario.focus();
    }
    else if(clave.value == ""){
        contenedoruser.classList.remove("is-invalid");
        contenedorpass.classList.add("is-invalid");
        clave.focus();
    }
    else{
        const url = base_url + "Usuarios/Validar";
        const frm = document.getElementById("frmLogin")
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                const res = JSON.parse(this.responseText);
                if(res == "ok"){
                    window.location = base_url + "Configuracion/home";
                }
                else{
                    document.getElementById("alerta").classList.remove("d-none")
                    document.getElementById("alerta").innerHTML = res;
                }
            }
        }
    }
}