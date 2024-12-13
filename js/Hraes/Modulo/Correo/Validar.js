function validarCorreo(){
    let correo_electronico = document.getElementById('correo_electronico').value;

    if (validarData(correo_electronico,'Correo electrónico') &&
        validarEmail(correo_electronico)
    ){
        guardarCorreo();
    }
}
                            

function validarEmail(valor) {
    if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
     return true; ///Email correcto
    } else {
        notyf.error('Ingrese un correo electrónico valido');
        return false; ///Email incorrecto
    }
  }
