function validar(){
    let nombre = document.getElementById('nombre').value.trim();
    let rfc = document.getElementById('rfc').value.trim();
    let primer_apellido = document.getElementById('primer_apellido').value.trim();
    let curp = document.getElementById('curp').value.trim();
    let num_empleado = document.getElementById('num_empleado').value.trim();
    let id_cat_pais_nacimiento = document.getElementById('id_cat_pais_nacimiento').value.trim();
    //let pais_nacimiento = document.getElementById('pais_nacimiento').value.trim();
    //let id_cat_genero = document.getElementById('id_cat_genero').value.trim();
    let id_cat_estado_civil = document.getElementById('id_cat_estado_civil').value.trim();
    let id_object = document.getElementById('id_object').value;
    let nss = document.getElementById('nss').value;
    let nacionalidad = document.getElementById('nacionalidad').value;
    
    if (validarData(nombre,'Nombre') &&
        validarData(rfc,'Rfc') &&
        validarData(primer_apellido,'Apellido paterno') &&
        validarData(curp,'Curp') &&
        validarData(num_empleado,'Num. empleado') &&
        validarData(id_cat_pais_nacimiento,'País de nacimiento') &&
        validarData(nacionalidad,'Nacionalidad') &&
        validarData(id_cat_estado_civil,'Estado civil') &&
        campoInvalido(validarCurp(curp),'Curp') &&
        campoInvalido(validarRFC(rfc),'Rfc') &&
        caracteresCount('Núm. de seguro social',12,nss)
    ){
        if (nss.length == 11 || nss.length == 0){
            if (nss > 0 || nss.length == 0){
                validarUnique(rfc,curp,num_empleado,id_object);
            } else {
                notyf.error('Núm. de seguro social no valido');
            }
            
        } else {
            notyf.error('El Núm. de seguro social debe tener 11 caracteres');
        }
    }
}


function validarUnique(rfc,curp,numEmpleado,id_object){
    $.post("../../../../App/Controllers/Central/EmpleadoC/ValidarC.php", {
        rfc: rfc,
        curp:curp,
        numEmpleado:numEmpleado,
        id_object:id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);//se obtiene el json
            let bool = jsonData.bool; 
            let message = jsonData.message;
            
            if(bool){
                agregarEditarByDb();
            } else {
                notyf.error(message);
            }
        }
    );
}

function obtenerGenero(){
    let curp = document.getElementById('curp').value.trim();
    let textoEnMayusculas = curp.toUpperCase();
    document.getElementById("curp").value = textoEnMayusculas;

    $("#genero_x").val(generoCurp(curp));
}

function generoCurp(curp){
    let result = curp.substring(10, 11);
    let message = 'NO ENCONTRADO';

    if(result.toUpperCase() == 'M'){
        message = 'FEMENINO';
    } else if (result.toUpperCase() == 'H'){
        message = 'MASCULINO';
    } else if (result.toUpperCase() == 'X'){
        message = 'OTRO';
    }
    return message;
}
/*
document.getElementById("id_cat_pais_nacimiento").addEventListener("change", function() {
    let id_cat_pais_nacimiento = this.value;
    $.post("../../../../App/Controllers/Hrae/EmpleadoC/EstadoC.php", {
        id_cat_pais_nacimiento: id_cat_pais_nacimiento,
    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            let estado = jsonData.estado; 

            $('#id_cat_estado_nacimiento').empty();
            $('#id_cat_estado_nacimiento').html(estado); 
            $('#id_cat_estado_nacimiento').selectpicker('refresh');
            $('.selectpicker').selectpicker 
        }
    );
  });
  */


  document.addEventListener("DOMContentLoaded", function() {

    var select = document.getElementById("id_cat_pais_nacimiento");
    select.addEventListener("change", function() {
        $.post("../../../../App/Controllers/Central/EmpleadoC/EstadoC.php", {
            id_cat_pais_nacimiento: select.value,
        },
            function (data) {
                let jsonData = JSON.parse(data);
                let estado = jsonData.estado; 
    
                $('#id_cat_estado_nacimiento').empty();
                $('#id_cat_estado_nacimiento').html(estado); 
                $('#id_cat_estado_nacimiento').selectpicker('refresh');
                $('.selectpicker').selectpicker 
            }
        );
    });
  });
