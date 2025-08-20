function validarIncidencia(){
    let id_cat_incidencias_ins = document.getElementById('id_cat_incidencias_ins').value;
    let fecha_inicio_ins = document.getElementById('fecha_inicio_ins').value;
    let fecha_fin_ins = document.getElementById('fecha_fin_ins').value;
    let observaciones_ins = document.getElementById('observaciones_ins').value;
    let fecha_captura_ins = document.getElementById('fecha_captura_ins').value;
    let hora_ins = document.getElementById('hora_ins').value;

    if (
        validarData(id_cat_incidencias_ins,'Tipo de incidencia') && 
        validarData(fecha_inicio_ins,'Fecha de inicio') &&
        validarData(fecha_captura_ins,'Fecha de justificación')
    ){
        if (
            id_cat_incidencias_ins == dias_cuenta_vacaciones ||
            id_cat_incidencias_ins == vacaciones_extraordinarias ||
            id_cat_incidencias_ins == vacaciones_ordinarias
        ){
            if(validarVacaciones()){
                guardarIncidencia();
            }
        } else {
            if (validarData(fecha_fin_ins,'Fecha fin') && validarFechas()){
                guardarIncidencia();
            }
        }
    }
}

function validarVacaciones() {
    // Obtención de valores
    let id_periodo = document.getElementById('periodo_oficial_ins').value;
    let es_mas_de_un_dia = document.getElementById('es_mas_de_un_dia');
    let fecha_inicio_ins = document.getElementById('fecha_inicio_ins').value;
    let fecha_fin_ins = document.getElementById('fecha_fin_ins').value;

    // Validar periodo
    if (id_periodo === '') {
        notyf.error('Debe seleccionar un periodo oficial.');
        return false;
    }

    // Validar fechas si es más de un día
    if (es_mas_de_un_dia.checked) {
        if (!validarData(fecha_fin_ins, 'Fecha fin') || !validarFechasIguales()) {
            return false;
        }
    }

    // Todo está bien, permitir guardar
    return true;
}




 //Cuando el select cambia su valor, se mostran los calendarios y se limpiaran los input
 document.getElementById("id_cat_incidencias_ins").addEventListener("change", function() {
    let id_cat_incidencias_ins = this.value;
    if(id_cat_incidencias_ins == dias_cuenta_vacaciones || 
        id_cat_incidencias_ins == vacaciones_extraordinarias || 
        id_cat_incidencias_ins == vacaciones_ordinarias){
          mostrarContenido('ocultar_contenido_vacaciones');
          checkbox_disabled.disabled  = true;
     } else {
        ocultarContenido('ocultar_contenido_vacaciones');
        checkbox_disabled.disabled  = false;
     }

     $("#fecha_fin_ins").val('');
     $("#fecha_inicio_ins").val('');
     $("#is_dias_seleccionados").val('');
     $("#is_dias_restantes").val('');
     $("#is_peridodo_ins").val('');
  });
 
 //Codigo para obtener el checkbox y congelar el valor de fecha inicial y final
 let checkbox = document.getElementById('es_mas_de_un_dia');
 checkbox.addEventListener('change', function() {
     if (checkbox.checked) {
         checkbox_disabled.disabled  = false;
     } else {
         checkbox_disabled.disabled  = true;
         $("#fecha_fin_ins").val('');
     }
     obtenerValoresIns();
 });

 //obtener el valor de fecha
 document.getElementById('fecha_inicio_ins').addEventListener('change', function() {
    validarFechas();
    obtenerValoresIns();
});

//obtener el valor de fecha fin
document.getElementById('fecha_fin_ins').addEventListener('change', function() {
    validarFechas();
    obtenerValoresIns();
});

//la funcion obtiene los parametros, como dias restantes, dias seleccionados y periodo
function obtenerValoresIns(){
    let fecha_fin_ins = document.getElementById('fecha_fin_ins').value;
    let fecha_inicio_ins = document.getElementById('fecha_inicio_ins').value;
    let id_periodo = document.getElementById('periodo_oficial_ins').value;

    $.post("../../../../App/Controllers/Central/IncidenciasC/ValoresC.php", {
        fecha_fin_ins: fecha_fin_ins,
        fecha_inicio_ins: fecha_inicio_ins,
        id_tbl_empleados_hraes: id_tbl_empleados_hraes,
        id_periodo: id_periodo
    },
        function (data) {
            let jsonData = JSON.parse(data);
            // Eliminar esta línea
            // $("#is_peridodo_ins").val(jsonData.periodo);
            $("#is_dias_seleccionados").val(jsonData.diasSeleccionados);
            $("#is_dias_restantes").val(jsonData.diasRestantes);
        }
    );
}




//la funcion valida que la fecha de inicio no sea menor a la fecha fin
function validarFechas(){
    let bool = true;
    let fecha_inicio_ins = document.getElementById('fecha_inicio_ins').value;
    let fecha_fin_ins = document.getElementById('fecha_fin_ins').value;

    if (fecha_inicio_ins > fecha_fin_ins && fecha_inicio_ins && fecha_fin_ins){
        notyf.error('La fecha de Fin no puede ser menor a la fecha de Inicio');
        bool = false;
    }

    return bool
}

function validarFechasIguales(){
    let bool = true;
    let fecha_inicio_ins = document.getElementById('fecha_inicio_ins').value;
    let fecha_fin_ins = document.getElementById('fecha_fin_ins').value;

    if (fecha_inicio_ins >= fecha_fin_ins && fecha_inicio_ins && fecha_fin_ins){
        notyf.error('La fecha de Fin no puede ser menor o igual a la fecha de Inicio');
        bool = false;
    }

    return bool
}