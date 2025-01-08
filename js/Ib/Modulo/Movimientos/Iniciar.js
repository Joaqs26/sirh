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
            $("#tabla_movimientos").html(data); 
        }
    );
}

function    (id_object){
    $("#id_object").val(id_object);
    let titulo = document.getElementById("tituloMovimiento");
    titulo.textContent = 'Modificar';
    if (id_object == null){
        titulo.textContent = 'Agregar';
        $("#agregar_editar_movimiento").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Central/MovimientosC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let entity = jsonData.response;
            let caracter = jsonData.caracter;
            let general = jsonData.general;
            let especifico = jsonData.especifico;
            let plaza = jsonData.plaza;
            let contratacion = jsonData.contratacion;
            let centroTrabajo = jsonData.centroTrabajo;

            $('#movimiento_general').empty();
            $('#movimiento_general').html(general); 

            $('#id_cat_caracter_nom_hraes').empty();
            $('#id_cat_caracter_nom_hraes').html(caracter); 
            
            $('#id_tbl_control_plazas_hraes').empty();
            $('#id_tbl_control_plazas_hraes').html(plaza); 
            $('#id_tbl_control_plazas_hraes').selectpicker('refresh');
            $('.selectpicker').selectpicker();

            $('#id_tbl_movimientos').empty();
            $('#id_tbl_movimientos').html(especifico); 

            $('#fecha_movimiento').val(entity.fecha_movimiento); 
            $('#fecha_inicio').val(entity.fecha_inicio); 
            $('#fecha_termino').val(entity.fecha_termino);
            $('#id_plaza').val(entity.id_tbl_control_plazas_hraes); 
            $('#motivo_estatus').val(entity.motivo_estatus);
            $('#observaciones').val(entity.observaciones); 

            $('#tipo_contratacion_mx').val(contratacion); 
            $('#centro_trabajo_mx').val(centroTrabajo);

            mostrarContenido('ocultar_model');
            ocultarContenido('ocultar_model_plaza');
            $('#situacionPlaza').val(null);
        }
    );

    $("#agregar_editar_movimiento").modal("show");
}


function salirAgregarEditarMovimiento(){
    $("#agregar_editar_movimiento").modal("hide");
}


function guardarMovimiento() {
    $.post("../../../../App/Controllers/Central/MovimientosC/AgregarEditarC.php", {
        id_tbl_movimientos: $("#id_tbl_movimientos").val(),
        fecha_movimiento: $("#fecha_movimiento").val(),
        id_tbl_control_plazas_hraes: $("#id_tbl_control_plazas_hraes").val(),
        fecha_inicio: $("#fecha_inicio").val(),
        fecha_termino: $("#fecha_termino").val(),
        id_cat_caracter_nom_hraes: $("#id_cat_caracter_nom_hraes").val(),
        motivo_estatus: $("#motivo_estatus").val(),
        observaciones: $("#observaciones").val(),
        id_tbl_empleados_hraes:id_tbl_empleados_hraes,
        id_object: $("#id_object").val(),
        movimiento_general: $("#movimiento_general").val(),
        num_plaza: $("#num_plaza_new").val(),
        id_cat_situacion_plaza_hraes: $("#situacionPlaza").val(),
        movimientoBaja:movimientoBaja,
        movimientoAlta:movimientoAlta,
        movimientoMov:movimientoMov,
    },
        function (data) {
            if (data == 'edit'){
                mensajeExito('Movimiento modificado con éxito');
            } else if (data == 'add') {
                mensajeExito('Movimiento agregado con éxito');  
            } else {
                mensajeError(data);
            }
            $("#agregar_editar_movimiento").modal("hide");
            buscarMovimiento();
            buscarInfoEmpleado(id_tbl_empleados_hraes);
        }
    );
}

function eliminarMovimiento(id_object) {//ELIMINAR USUARIO
    if(validarAccion()){
    Swal.fire({
        title: "¿Está seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
        $.post("../../../../App/Controllers/Central/MovimientosC/EliminarC.php", {
                id_object: id_object
            },
            function (data) {
                if (data == 'delete'){
                    mensajeExito('Movimiento eliminado con éxito')
                } else {
                    mensajeError(data);
                }
                buscarMovimiento();
            }
        );
    }
    });
}
}

