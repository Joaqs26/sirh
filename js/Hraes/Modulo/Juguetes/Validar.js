var id_ctrl_dependientes_economicos_j = document.getElementById('id_ctrl_dependientes_economicos_j');
var id_cat_fecha_juguetes_j = document.getElementById('id_cat_fecha_juguetes_j');
var id_cat_estatus_juguetes_j = document.getElementById('id_cat_estatus_juguetes_j');
var id_object = document.getElementById('id_object');
var curp_j = document.getElementById('curp_j');

function validarJuguete(){/// LA FUNCION
    if (validarData(id_ctrl_dependientes_economicos_j.value,'Dependiente económico') &&
        validarData(id_cat_fecha_juguetes_j.value,'Fecha') &&
        validarData(id_cat_estatus_juguetes_j.value,'Estatus')
    ){
        if (validarFechaNacimiento(curp_j.value,obtenerValorSelect(id_cat_fecha_juguetes_j))){
            existeMenor(id_object.value,curp_j.value,id_cat_fecha_juguetes_j.value);
        } else{
            mensajeError('El usuario ingresado no cumple con la edad solicitada');
        }
    }
}

///FUNCION PARA CAMBIAR EL ESTADO DE CURP
document.getElementById("id_ctrl_dependientes_economicos_j").addEventListener("change", function() {
    let id_ctrl_dependientes_economicos_hraes = this.value;
    $.post("../../../../App/Controllers/Hrae/JuguetesC/CurpC.php", {
        id_ctrl_dependientes_economicos_hraes: id_ctrl_dependientes_economicos_hraes,
    },
        function (data) {
            var jsonData = JSON.parse(data);
            var value = jsonData.value; 
            $('#curp_j').val(value.curp);
        }
    );
  });

  /*
function handleChange(event){
    console.log('success');
    let selectedOption = event.target.options[event.target.selectedIndex];
    let id_ctrl_dependientes_economicos_hraes = selectedOption.value;

    $.post("../../../../App/Controllers/Hrae/JuguetesC/CurpC.php", {
        id_ctrl_dependientes_economicos_hraes: id_ctrl_dependientes_economicos_hraes,
    },
        function (data) {
            var jsonData = JSON.parse(data);
            var value = jsonData.value; 
            $('#curp_j').val(value.curp);
        }
    );
}
*/

///LA FUNCION PERMITE VALIDAR QUE LA CURP NO EXISTA EN EL SISTEMA DE JUEGOS
function existeMenor(id_object,curp_j,id_cat_fecha_juguetes_j){
    $.post("../../../../App/Controllers/Hrae/JuguetesC/ValidarMenorC.php", {
        id_object: id_object,
        curp_j:curp_j,
        id_cat_fecha_juguetes_j:id_cat_fecha_juguetes_j
    },
        function (data) {
            if (data != 'true'){
                agregarEditarByDbByJuguete(); ///CANDIDATO VALIDO -> GUARDAR INFO
            } else {
                notyf.error('Ya se encuentra un registro con la información proporcionada');
            }
        }
    );
}


