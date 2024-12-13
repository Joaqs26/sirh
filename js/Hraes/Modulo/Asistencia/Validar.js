function validarAsistencia(){
    let fecha_ss_ = document.getElementById('fecha_ss_').value;
    let hora_ss_ = document.getElementById('hora_ss_').value;
    let dispositivo_ss = document.getElementById('dispositivo_ss').value;
    let verificacion_ss = document.getElementById('verificacion_ss').value;
    let estado_ss = document.getElementById('estado_ss').value;
    let evento_ss = document.getElementById('evento_ss').value;

    if (validarData(fecha_ss_,'Fecha') &&
        validarData(hora_ss_,'Hora') &&
        validarData(dispositivo_ss,'Nombre de dispositivo') &&
        validarData(verificacion_ss,'Tipo de verificación') &&
        validarData(estado_ss,'Estado') &&
        validarData(evento_ss,'Evento') 
    ){
        guardarAsistencia();
    }
}
                            
