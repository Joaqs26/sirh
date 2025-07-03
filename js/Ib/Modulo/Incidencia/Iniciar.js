var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;
var checkbox_disabled = document.getElementById("checkbox_disabled");
var es_mas_de_un_dia = document.getElementById('es_mas_de_un_dia');

var dias_cuenta_vacaciones = 7;
var vacaciones_extraordinarias = 14;
var vacaciones_ordinarias = 15;

const selectIncidencia = document.getElementById('id_cat_incidencias_ins');
const campoNumOficio = document.getElementById('campo_num_oficio');


selectIncidencia.addEventListener('change', function () {
    const selectedText = selectIncidencia.options[selectIncidencia.selectedIndex].text.trim().toUpperCase();

    
    const fechaInicio = $("#fecha_inicio_ins").val();
    const fechaFin = $("#fecha_fin_ins").val();

    
    if (selectedText === 'VACACIONES EXTRAORDINARIAS') {
        campoNumOficio.style.display = 'block';
    } else {
        campoNumOficio.style.display = 'none';
    }

    
    const idSeleccionado = parseInt($("#id_cat_incidencias_ins").val());

    if (
        idSeleccionado === dias_cuenta_vacaciones ||
        idSeleccionado === vacaciones_extraordinarias ||
        idSeleccionado === vacaciones_ordinarias
    ) {
        mostrarContenido('ocultar_contenido_vacaciones');
    } else {
        ocultarContenido('ocultar_contenido_vacaciones');
    }

    
    setTimeout(() => {
        $("#fecha_inicio_ins").val(fechaInicio);
        $("#fecha_fin_ins").val(fechaFin);
        console.log("✔️ Fechas restauradas después del cambio de incidencia");
    }, 50);
});


function buscarIncidencia(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_ins);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_ins(null, iniciarBusqueda_ins(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_ins(buscarNew, iniciarBusqueda_ins(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_ins(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Central/Modulo/Incidencias/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_incidencia").html(data); 
        }
    );
}

function agregarEditarIncidencia(id_object) {
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_asistencia");
    titulo.textContent = id_object == null ? 'Agregar' : 'Modificar';

    if (id_object == null) {
        // Limpiar campos
        $("#agregar_editar_incidencia").find("input,textarea,select").val("");
        $("#agregar_editar_incidencia").find("input[type=checkbox], input[type=radio]").prop("checked", false);
        $("#campo_num_oficio").hide();
        $("#num_oficio_ins").val('');
        $("#periodo_oficial_ins").val('').trigger('change');
    }

    $.post("../../../../App/Controllers/Central/IncidenciasC/DetallesC.php", {
        id_object: id_object
    }, function (data) {
        let jsonData = JSON.parse(data);
        let response = jsonData.response;

        checkbox_disabled.disabled = false;
        ocultarContenido('ocultar_contenido_vacaciones');

        // Validar si es vacaciones
        if (
            response.id_cat_incidencias == dias_cuenta_vacaciones ||
            response.id_cat_incidencias == vacaciones_extraordinarias ||
            response.id_cat_incidencias == vacaciones_ordinarias
        ) {
            if (response.es_mas_de_un_dia !== 't') {
                checkbox_disabled.disabled = true;
                es_mas_de_un_dia.checked = false;
            } else {
                es_mas_de_un_dia.checked = true;
            }
            mostrarContenido('ocultar_contenido_vacaciones');
        }

        // Fechas
        const fechaInicio = response.fecha_inicio;
        const fechaFin = response.fecha_fin;

        $("#fecha_inicio_ins").val(fechaInicio);
        $("#fecha_fin_ins").val(fechaFin);
        $("#fecha_captura_ins").val(response.fecha_captura);
        $("#hora_ins").val(response.hora);
        $("#observaciones_ins").val(response.observaciones);

        // Num. Oficio
        if (response.num_oficio && response.num_oficio.trim() !== '') {
            $("#campo_num_oficio").show();
            $("#num_oficio_ins").val(response.num_oficio);
        } else {
            $("#campo_num_oficio").hide();
            $("#num_oficio_ins").val('');
        }

        // Días y periodo
        $("#is_peridodo_ins").val(jsonData.periodo);
        $("#is_dias_seleccionados").val(jsonData.diasSeleccionados);
        $("#is_dias_restantes").val(jsonData.diasRestantes);

        // Tipo incidencia
        $("#id_cat_incidencias_ins").html(jsonData.catIncidencias);
        $("#id_cat_incidencias_ins").val(response.id_cat_incidencias);
        $("#id_cat_incidencias_ins").selectpicker('refresh');

        // Rellenar select Periodo Oficial
        let selectPeriodos = $("#periodo_oficial_ins");
        selectPeriodos.empty();
        selectPeriodos.append('<option value="">Selecciona un periodo</option>');

        if (jsonData.periodos && Array.isArray(jsonData.periodos)) {
            jsonData.periodos.forEach(function(periodo) {
                let selected = "";
                if (response.id_cat_periodo && response.id_cat_periodo == periodo.id_cat_periodo) {
                    selected = "selected";
                }
                selectPeriodos.append(`<option value="${periodo.id_cat_periodo}" ${selected}>${periodo.descripcion}</option>`);
            });
        }

        // Restaurar fechas después del refresh
        setTimeout(() => {
            $("#fecha_inicio_ins").val(fechaInicio);
            $("#fecha_fin_ins").val(fechaFin);
        }, 50);

        $('.selectpicker').selectpicker();
    });

    $("#agregar_editar_incidencia").modal("show");
}




function salirAgregarEditarIncidencia(){
    $("#agregar_editar_incidencia").modal("hide");
}

//accion para guardar la informacion de incidencias
function guardarIncidencia() {

    let checkbox_value = document.getElementById('es_mas_de_un_dia');
    checkbox_value = checkbox_value.checked ? true : false;

    $.post("../../../../App/Controllers/Central/IncidenciasC/AgregarEditarC.php", {
    id_tbl_empleados_hraes: id_tbl_empleados_hraes,
    es_mas_de_un_dia: checkbox_value,
    fecha_inicio: $("#fecha_inicio_ins").val(),
    fecha_fin: $("#fecha_fin_ins").val(),
    fecha_captura: $("#fecha_captura_ins").val(),
    hora: $("#hora_ins").val(),
    observaciones: $("#observaciones_ins").val(),
    id_cat_incidencias: $("#id_cat_incidencias_ins").val(),
    id_object: $("#id_object").val(),
    num_oficio: $("#num_oficio_ins").val(),
    id_cat_periodo: $("#periodo_oficial_ins").val() // <- NUEVO: Enviar el periodo oficial
},
function (data) {
    console.log('respuesta:', data); 
    if (data == 'edit'){
        notyf.success('Incidencia modificada con éxito');
    } else if (data == 'add') {
        notyf.success('Incidencia agregada con éxito');  
    } else {
        notyf.error(mensajeSalida);
    }
    $("#agregar_editar_incidencia").modal("hide");
    buscarIncidencia();
});

}

function eliminarIncidecia(id_object) {//ELIMINAR USUARIO
    Swal.fire({
        title: "¿Está seguro?",
        text: "¡No podrás revertir esto!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#235B4E",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
        $.post("../../../../App/Controllers/Central/IncidenciasC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                console.log('respuesta:', data); 
                if (data == 'delete'){
                     console.log('respuesta:', data); 
                    notyf.success('Incidencia eliminada con éxito')
                } else {
                    notyf.error(mensajeSalida);
                }
                buscarIncidencia();
            }
        );
    }
    });
}


function obtenerUsuario(id){
    buscarAsistencia();
    let nombre_usuario_accion = document.getElementById("nombre_usuario_accion");
    nombre_usuario_accion.textContent = '-';
    if (typeof id !== 'undefined') {
    $.post("../../../../App/Controllers/Central/AsistenciaC/UsuariosC.php", {
        id: id,
    },
        function (data) {
            nombre_usuario_accion.textContent = data;
        }
    );
    }
    mostrarModalUsuario();
}

function mostrarModalUsuario(){
    $("#mostrar_usuario").modal("show");
}

function ocultarModalUsuario(){
    $("#mostrar_usuario").modal("hide");
}

