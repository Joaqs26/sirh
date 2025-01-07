function validarDependiente_(){
    let fecha_rr = document.getElementById('fecha_rr').value;
    let hora_ss = document.getElementById('hora_ss').value;
    let id_cat_retardo_tipo = document.getElementById('id_cat_retardo_tipo').value;
    let id_cat_retardo_estatus = document.getElementById('id_cat_retardo_estatus').value;
    let observaciones_rr = document.getElementById('observaciones_rr').value;
    
    if (validarData(fecha_rr,'Fecha') &&
        validarData(hora_ss,'Hora') &&
        validarData(id_cat_retardo_tipo,'Tipo de retardo') &&
        validarData(id_cat_retardo_estatus,'Retardo estatus') &&
        validarData(observaciones_rr,'Observaciones')
    ){
        guardarRetardoX();
    }    
}

//functiion get quincena
const dateInput = document.getElementById('fecha_rr');
dateInput.addEventListener('change', function() {
    let isValue = dateInput.value;
    
    $.post("../../../../App/Controllers/CentraL/CatQuincenaC/CatQuincenaC.php", {
        isValue: isValue
    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            $("#id_cat_quincenas").val(jsonData.id_cat_quincenas);
            $("#quincena_rr").val(jsonData.quincena);
            $("#periodo_quincena_rr").val(jsonData.quincenaPeriodo);
        }
    );

});