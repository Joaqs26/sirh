function validarTelefono(){
    let movil = document.getElementById('movil').value.trim();
    let id_cat_estatus = document.getElementById('id_cat_estatus').value.trim();
    let telefono = document.getElementById('telefono').value.trim();
    let id_object = document.getElementById('id_object').value.trim();


    if (validarData(movil,'Número telefónico') &&
        validarData(id_cat_estatus,'Estatus') &&
        caracteresCount('Número telefónico',10,movil) &&
        caracteresCount('Teléfono fijo',10,telefono)
    ){

        if(movil.length == 10){
            if (telefono.length == 10 || telefono.length == 0){
                validarEstatusTelefono(id_object, id_cat_estatus);
            } else {
                notyf.error('Teléfono fijo debe tener 10 caracteres');
            }
        } else {
            notyf.error('Número telefónico debe tener 10 caracteres');
        }
        
    }
}

function validarEstatusTelefono(id_object, id_cat_estatus) { 
    $.post('../../../../App/Controllers/Hrae/TelefonoC/ValidarEstatusC.php', {
        id_object: id_object, 
        id_cat_estatus: id_cat_estatus,
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            jsonData = JSON.parse(data);
            let bool = jsonData.bool;
            let message = jsonData.message;

            if(bool){
                agregarEditarByDbByTelefono();
            } else {
                notyf.error(message);
            }
        }
    );
}

function caracteresCount(text, number,value){
    let bool = true;
    if(value.length > number){
        bool = false
        notyf.error(text + ' debe tener hasta un máximo de ' + number + ' caracteres')
    } 
    return bool;
}

function esEntero(text,num) {
    let bool = true;
    if (num.includes('.')){
        bool = false;
        notyf.error(text + ' debe tener números enteros')
    }
    return bool;
}