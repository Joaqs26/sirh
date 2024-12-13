
var idExcluido = 4; ///catalogo de estatus excluido

function validadConfAsistencia(){

    let no_dispositivo_ass = document.getElementById('no_dispositivo_ass').value;
    let id_cat_asistencia_estatus = document.getElementById('id_cat_asistencia_estatus').value;
    let id_cat_jornada_turno = document.getElementById('id_cat_jornada_turno').value;
    let id_cat_jornada_dias = document.getElementById('id_cat_jornada_dias').value;
    let id_cat_jornada_horario = document.getElementById('id_cat_jornada_horario').value;
    let id_cat_asistencia_ubicacion = document.getElementById('id_cat_asistencia_ubicacion').value;
    let observaciones_ass = document.getElementById('observaciones_ass').value;
    let fecha_inicio_ss = document.getElementById('fecha_inicio_ss').value;
    let fecha_fin_ss = document.getElementById('fecha_fin_ss').value;

    if (validarData(no_dispositivo_ass,'No biométrico') &&
        validarData(id_cat_asistencia_estatus,'Estatus') &&
        validarData(id_cat_jornada_turno,'Turno') &&
        validarData(id_cat_jornada_dias,'Jornada') &&
        validarData(id_cat_jornada_horario,'Horario') &&
        validarData(id_cat_asistencia_ubicacion,'Ubicación') &&
        validarData(observaciones_ass,'Observaciones') 
        ){
            if(id_cat_asistencia_estatus == idExcluido){
                if (validarData(fecha_inicio_ss,'Fecha de inicio') &&
                    validarData(fecha_fin_ss,'Fecha de fin') && 
                    validarFecha(fecha_inicio_ss, fecha_fin_ss)
                ){
                    uniqueNoBiometrico();
                }
            } else {
                uniqueNoBiometrico();
            }     
    }
    
}


function validarFecha(fechaInicio, fechaFin){
    let bool = true;

    if(fechaInicio >= fechaFin){
        bool = false;
        notyf.error('La fecha de inicio no puede ser posterior a la fecha de fin.');
    }
    return bool;
}


function uniqueNoBiometrico(){
    let no_dispositivo_ass = document.getElementById('no_dispositivo_ass').value;
    $.post("../../../../App/Controllers/Hrae/AsistenciaConfC/ValidarNoC.php", {
        id_tbl_empleados_hraes: id_tbl_empleados_hraes,
        no_dispositivo_ass: no_dispositivo_ass
    },
        function (data) {
            if (data){
                notyf.error('El No biométrico* ya se encuentra asociado a un empleado'); 
            } else {
                agregarActualizarAsistencia();
            }
            }
    );
}


document.getElementById("id_cat_asistencia_estatus").addEventListener("change", function() {
    let id_cat_asistencia_estatus = this.value;
    
    if ( id_cat_asistencia_estatus == idExcluido){
        mostrarContenido('id_estatus_is_div');
    } else {
        ocultarContenido('id_estatus_is_div');
    }
  });

