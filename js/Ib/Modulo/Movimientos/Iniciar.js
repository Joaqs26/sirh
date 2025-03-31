var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarMovimiento(){ //BUSQUEDA
    let buscarNew = clearElement(buscar_mv);
    let buscarlenth = lengthValue(buscarNew);
    
    if (buscarlenth == 0){
        iniciarTabla_mv(null, iniciarBusqueda_mv(),id_tbl_empleados_hraes);
    } else {
        iniciarTabla_mv(buscarNew, iniciarBusqueda_mv(),id_tbl_empleados_hraes);
    }
}

function iniciarTabla_mv(busqueda, paginador, id_tbl_empleados_hraes) { 
    $.post('../../../../App/View/Central/Modulo/Movimientos/tabla.php', {
        busqueda: busqueda, 
        paginador: paginador, 
        id_tbl_empleados_hraes:id_tbl_empleados_hraes
    },
        function (data) {
            console.log(data);
            $("#tabla_movimientos").html(data); 
        }
    );
}

function agregarEditarMovimiento(id_object) {
    $("#id_object").val(id_object);
    let titulo = document.getElementById("tituloMovimiento");
    titulo.textContent = id_object == null ? 'Agregar' : 'Modificar';

    if (id_object == null) {

        $("#agregar_editar_movimiento").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Central/MovimientosC/DetallesC.php", {
        id_object: id_object
    }, function (data) {
        console.log("📥 Datos recibidos del backend:", data); // Inspect the response here

        try {
            let jsonData = JSON.parse(data);
            let entity = jsonData.response;
            let caracter = jsonData.caracter;
            let general = jsonData.general;
            let especifico = jsonData.especifico;
            let plaza = jsonData.plaza;
            let contratacion = jsonData.contratacion;
            let centroTrabajo = jsonData.centroTrabajo;
            let tipoTrabajador = jsonData.tipo_trabajador;
            let descripcionTipoTrabajador = jsonData.descripcion_tipo_trabajador;

            console.log("🧾 Movimiento recibido (ID):", entity.id_tbl_movimientos);

            // Cargar combos
            $('#movimiento_general').empty().html(general);
            $('#id_cat_caracter_nombramiento').empty().html(caracter);
            $('#id_tbl_control_plazas_hraes').empty().html(plaza).selectpicker('refresh');
            $('#id_tbl_movimientos').empty().html(especifico);
            $('.selectpicker').selectpicker();

            // Cargar campos
            $('#fecha_movimiento').val(entity.fecha_movimiento);
            $('#fecha_inicio').val(entity.fecha_inicio);
            $('#fecha_termino').val(entity.fecha_termino);
            $('#id_plaza').val(entity.id_tbl_control_plazas_hraes);
            $('#motivo_estatus').val(entity.motivo_estatus);
            $('#observaciones').val(entity.observaciones);
            $('#tipo_contratacion_mx').val(contratacion);
            $('#centro_trabajo_mx').val(centroTrabajo);
            $('#situacionPlaza').val(null);

            // Validar si el movimiento específico corresponde a Alta (ej. 2 o 4)
            let movimientoEspecificoID = parseInt(entity.id_tbl_movimientos);

            if (movimientoEspecificoID === 2 || movimientoEspecificoID === 4) {
                console.log("✅ Movimiento de tipo ALTA, mostrando campo de tipo de trabajador");
                $('#campo_tipo_trabajador').show();
                $('#id_cat_tipo_trabajador').empty().html(descripcionTipoTrabajador).selectpicker('refresh');
                $('.selectpicker').selectpicker();
     /*
                $('#id_cat_tipo_trabajador').empty().append(`<option value="${tipoTrabajador}">${descripcionTipoTrabajador}</option>`).val(tipoTrabajador).trigger("change");
                $('.selectpicker').selectpicker();
             
                /*   
                if (tipoTrabajador !== 1 && tipoTrabajador !== "1") {
                    $('#id_cat_tipo_trabajador').empty().append(`<option value="${tipoTrabajador}">${descripcionTipoTrabajador}</option>`).val(tipoTrabajador).trigger("change");
                } else {
                    console.warn("⚠️ No se recibió tipo_trabajador desde el backend.");
                    $('#id_cat_tipo_trabajador').empty().append('<option value="">Seleccione</option>').trigger("change");
                }
*/

            } else {
                console.log("ℹ️ Movimiento no es ALTA, ocultando campo de tipo de trabajador");
                $('#campo_tipo_trabajador').hide();
                $('#id_cat_tipo_trabajador').empty().append('<option value="">Seleccione</option>').trigger("change");
            }
        } catch (error) {
            console.error("JSON parsing error:", error);
            console.log("🔍 Response content:", data); // Log the response content
        }
    });

    $("#agregar_editar_movimiento").modal("show");
}

function salirAgregarEditarMovimiento() {
    $("#agregar_editar_movimiento").modal("hide");
}




function guardarMovimiento() {
    var id_tbl_empleados_hraes = $('#id_tbl_empleados_hraes').val();

    if (!id_tbl_empleados_hraes) {
        mensajeError("El ID del empleado no está definido. No se puede guardar el movimiento.");
        return;
    }

    $.post("../../../../App/Controllers/Central/MovimientosC/AgregarEditarC.php", {
        id_tbl_movimientos: $("#id_tbl_movimientos").val(),
        fecha_movimiento: $("#fecha_movimiento").val(),
        id_tbl_control_plazas_hraes: $("#id_tbl_control_plazas_hraes").val(),
        fecha_inicio: $("#fecha_inicio").val(),
        fecha_termino: $("#fecha_termino").val(),
        id_cat_caracter_nombramiento: $("#id_cat_caracter_nombramiento").val(),
        motivo_estatus: $("#motivo_estatus").val(),
        observaciones: $("#observaciones").val(),
        id_tbl_empleados_hraes: id_tbl_empleados_hraes, // ✅ Validación para que no sea vacío
        id_object: $("#id_object").val(),
        movimiento_general: $("#movimiento_general").val(),
        num_plaza: $("#num_plaza_new").val(),
        id_cat_situacion_plaza_hraes: $("#situacionPlaza").val(),
        id_cat_tipo_trabajador: $("#id_cat_tipo_trabajador").val(), // ✅ Se agrega el tipo de trabajador
        movimientoBaja: movimientoBaja,
        movimientoAlta: movimientoAlta,
        movimientoMov: movimientoMov,
    }, function (data) {
        console.log(data);
        if (data === 'edit') {
            mensajeExito('Movimiento modificado con éxito');
        } else if (data === 'add') {
            mensajeExito('Movimiento agregado con éxito');
        } else {
            mensajeError(data);
        }
        $("#agregar_editar_movimiento").modal("hide");
        buscarMovimiento();
    });
}


function eliminarMovimiento(id_object) {
    if (validarAccion()) {
        Swal.fire({
            title: "¿Está seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("../../../../App/Controllers/Central/MovimientosC/EliminarC.php", {
                    id_object: id_object
                }, function (data) {
                    console.log(data);
                    if (data == 'delete') {
                        mensajeExito('Movimiento eliminado con éxito');
                    } else {
                        mensajeError(data);
                    }
                    buscarMovimiento();
                });
            }
        });
    }
}
