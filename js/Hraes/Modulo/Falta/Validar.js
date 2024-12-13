function validarFalta_() {
    let fecha_desde_ = document.getElementById('fecha_desde_').value;
    let fecha_hasta_ = document.getElementById('fecha_hasta_').value;
    let fecha_registro_ = document.getElementById('fecha_registro_').value;
    let codigo_certificacion_ = document.getElementById('codigo_certificacion_').value;
    let id_cat_retardo_tipo_ = document.getElementById('id_cat_retardo_tipo_').value;
    let id_cat_retardo_estatus_ = document.getElementById('id_cat_retardo_estatus_').value;
    let fecha_ = document.getElementById('fecha_').value;
    let hora_ = document.getElementById('hora_').value;
    let cantidad_ = document.getElementById('cantidad_').value;
    let observaciones_ = document.getElementById('observaciones_').value;
    const checkbox = document.getElementById("es_por_retardo");


    if (checkbox.checked) { //select
        if (validarData(id_cat_retardo_tipo_, 'Tipo de falta') &&
            validarData(id_cat_retardo_estatus_, 'Estatus') &&
            validarData(fecha_, 'Fecha') &&
            validarData(cantidad_, 'Cantidad') &&
            validarData(observaciones_, 'Observaciones')
        ) {
            if (cantidad_ <= 5) {
                guardarFalta(true);
            } else {
                notyf.error('Cantidad no puede ser mayor a 5');
            }
        }
    } else {
        if (validarData(fecha_desde_, 'Fecha desde') &&
            validarData(fecha_hasta_, 'Fecha hasta') &&
            validarData(fecha_registro_, 'Fecha de registro') &&
            validarData(codigo_certificacion_, 'Código certificación') &&
            validarData(observaciones_, 'Observaciones')
        ) {
            guardarFalta(false);
        }
    }
}



document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById("es_por_retardo");

    checkbox.addEventListener("change", function () {
        if (this.checked) { //is active
            mostrarContenido('falta_retardo');
            ocultarContenido('falta_');
            checkbox.checked = true;
            $("#agregar_editar_falta").find("input,textarea,select").val("");
            $("#agregar_editar_falta").find("select").val("").selectpicker('refresh');
        } else {
            mostrarContenido('falta_');
            ocultarContenido('falta_retardo');
            checkbox.checked = false;
            $("#agregar_editar_falta").find("input,textarea,select").val("");
            $("#agregar_editar_falta").find("select").val("").selectpicker('refresh');
        }
    });
});