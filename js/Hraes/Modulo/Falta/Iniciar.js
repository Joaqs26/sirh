var id_tbl_empleados_hraes = document.getElementById('id_tbl_empleados_hraes').value;

function buscarFalta() { //BUSQUEDA
    let buscarNew = clearElement(buscar_fa);
    let buscarlenth = lengthValue(buscarNew);
    if (buscarlenth == 0) {
        iniciarTabla_fa(null, iniciarBusqueda_fa(), id_tbl_empleados_hraes);
    } else {
        iniciarTabla_fa(buscarNew, iniciarBusqueda_fa(), id_tbl_empleados_hraes);
    }
}

function iniciarTabla_fa(busqueda, paginador, id_tbl_empleados_hraes) {
    $.post('../../../../App/View/Hraes/Modulo/Falta/tabla.php', {
        busqueda: busqueda,
        paginador: paginador,
        id_tbl_empleados_hraes: id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_falta").html(data);
        }
    );
}

function agregarEditarFalta(id_object) {
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_falta");
    let checkbox = document.getElementById("es_por_retardo");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null) {
        titulo.textContent = 'Agregar';
        $("#agregar_editar_falta").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/FaltaC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let entity = jsonData.response;
            let faltaEstatus = jsonData.faltaEstatus;
            let faltaTipo = jsonData.faltaTipo;

            if (entity.es_por_retardo == 't') {
                mostrarContenido('falta_retardo');
                ocultarContenido('falta_');
                checkbox.checked = true;

                $("#fecha_").val(entity.fecha);
                $("#hora_").val(entity.hora);
                $("#cantidad_").val(entity.cantidad);

                $('#fecha_desde_').val("");
                $('#fecha_hasta_').val("");
                $('#fecha_registro_').val("");
                $('#codigo_certificacion_').val("");
            } else {
                mostrarContenido('falta_');
                ocultarContenido('falta_retardo');
                checkbox.checked = false;

                $("#fecha_desde_").val(entity.fecha_desde);
                $("#fecha_hasta_").val(entity.fecha_hasta);
                $("#fecha_registro_").val(entity.fecha_registro);
                $("#codigo_certificacion_").val(entity.codigo_certificacion);

                $('#fecha_').val("");
                $('#hora_').val("");
                $('#cantidad_').val("");
            }


            $('#id_cat_retardo_estatus_').empty();
            $('#id_cat_retardo_tipo_').empty();

            $('#id_cat_retardo_estatus_').html(faltaEstatus);
            $('#id_cat_retardo_tipo_').html(faltaTipo);

            $('#id_cat_retardo_estatus_').selectpicker('refresh');
            $('#id_cat_retardo_tipo_').selectpicker('refresh');

            $('.selectpicker').selectpicker();
            $("#observaciones_").val(entity.observaciones);
        }
    );

    $("#agregar_editar_falta").modal("show");
}

function salirAgregarEditarFalta_() {
    $("#agregar_editar_falta").modal("hide");
}


function guardarFalta(es_por_retardo) {

    $.post("../../../../App/Controllers/Hrae/FaltaC/AgregarEditarC.php", {
        id_object: $("#id_object").val(),
        es_por_retardo: es_por_retardo,
        fecha_desde: $("#fecha_desde_").val(),
        fecha_hasta: $("#fecha_hasta_").val(),
        fecha_registro: $("#fecha_registro_").val(),
        codigo_certificacion: $("#codigo_certificacion_").val(),
        id_cat_retardo_tipo: $("#id_cat_retardo_tipo_").val(),
        id_cat_retardo_estatus: $("#id_cat_retardo_estatus_").val(),
        fecha: $("#fecha_").val(),
        hora: $("#hora_").val(),
        cantidad: $("#cantidad_").val(),
        observaciones: $("#observaciones_").val(),
        id_tbl_empleados_hraes: id_tbl_empleados_hraes
    },
        function (data) {
            if (data == 'edit') {
                notyf.success('Falta agregada con éxito');
            } else if (data == 'add') {
                notyf.success('Falta modificada con éxito');
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_falta").modal("hide");
            buscarFalta();
        }
    );
}

function eliminarFalta(id_object) {//ELIMINAR USUARIO
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
            $.post("../../../../App/Controllers/Hrae/FaltaC/EliminarC.php", {
                id_object: id_object
            },
                function (data) {
                    if (data == 'delete') {
                        notyf.success('Falta eliminada con éxito')
                    } else {
                        notyf.error(mensajeSalida);
                    }
                    buscarFalta();
                }
            );
        }
    });
}
