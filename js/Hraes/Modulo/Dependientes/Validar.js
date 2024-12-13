function validarDependienteD(){
    let nombre_d = document.getElementById('nombre_d').value;
    let curp_d = document.getElementById('curp_d').value;
    let apellido_paterno_d = document.getElementById('apellido_paterno_d').value;
    let id_cat_dependientes_economicos_d = document.getElementById('id_cat_dependientes_economicos_d').value;
    
    if (validarData(nombre_d,'Nombre') &&
        validarData(curp_d,'Curp') &&
        validarData(apellido_paterno_d,'Apellido paterno') &&
        validarData(id_cat_dependientes_economicos_d,'Tipo dependiente') &&
        campoInvalido(validarCurp(curp_d),'Curp')
    ){
        agregarEditarByDbByDependiente();
    }    
}

function campoInvalido(data, text){
    let bool = true;
    if (!data){
        notyf.error('Campo ' + text + '* no valido.');
        bool = false;
    } 
    return bool;
}