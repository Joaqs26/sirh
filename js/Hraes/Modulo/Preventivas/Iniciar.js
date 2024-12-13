function buscarPreventivas() { //BUSQUEDA
    let buscarNew = clearElement(buscar_pv);
    let buscarlenth = lengthValue(buscarNew);

    if (buscarlenth == 0) {
        iniciarTabla_pv(null, iniciarBusqueda_pv(), id_tbl_empleados_hraes);
    } else {
        iniciarTabla_pv(buscarNew, iniciarBusqueda_pv(), id_tbl_empleados_hraes);
    }
}

function iniciarTabla_pv(busqueda, paginador, id_tbl_empleados_hraes) {
    $.post('../../../../App/View/Hraes/Modulo/Preventivas/tabla.php', {
        busqueda: busqueda,
        paginador: paginador,
        id_tbl_empleados_hraes: id_tbl_empleados_hraes
    },
        function (data) {
            $("#tabla_preventivas").html(data);
        }
    );
}

function agregarEditarPreventiva(id_object) {
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_preventiva");
    titulo.textContent = 'Modificar';
    $("#id_object").val(id_object);
    if (id_object == null) {
        titulo.textContent = 'Agregar';
        $("#agregar_editar_preventiva").find("input,textarea,select").val("");
    }

    $.post("../../../../App/Controllers/Hrae/PreventivasC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {

            let jsonData = JSON.parse(data);
            let response = jsonData.response;
            let preventivas = jsonData.preventivas;
            let quincena = jsonData.quincena;
            let periodo = jsonData.periodo;

            $("#fecha_inicio_pv").val(response.fecha_inicio);
            $("#fecha_fin_pv").val(response.fecha_fin);
            $("#quincena_pv").val(quincena);
            $("#periodo_quincena_pv").val(periodo);
            $("#no_oficio_pv").val(response.no_oficio);
            $("#observaciones_pv").val(response.observaciones);

            $("#id_cat_preventivas").html(preventivas);
            $('#id_cat_preventivas').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    );
    $("#agregar_editar_preventiva").modal("show");
}

function salirAgregarEditarPreventiva() {
    $("#agregar_editar_preventiva").modal("hide");
}

//accion para guardar la informacion de incidencias
function guardarPreventiva() {

    $.post("../../../../App/Controllers/Hrae/PreventivasC/AgregarEditarC.php", {
        id_tbl_empleados_hraes: id_tbl_empleados_hraes,
        fecha_inicio: $("#fecha_inicio_pv").val(),
        fecha_fin: $("#fecha_fin_pv").val(),
        id_cat_preventivas: $("#id_cat_preventivas").val(),
        no_oficio: $("#no_oficio_pv").val(),
        observaciones: $("#observaciones_pv").val(),
        id_object: $("#id_object").val(),
    },
        function (data) {
            if (data == 'edit') {
                notyf.success('Preventiva modificada con éxito');
            } else if (data == 'add') {
                notyf.success('Preventiva agregada con éxito');
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_preventiva").modal("hide");
            buscarPreventivas();
        }
    );
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
            $.post("../../../../App/Controllers/Hrae/PreventivasC/EliminarC.php", {
                id_object: id_object
            },
                function (data) {
                    if (data == 'delete') {
                        notyf.success('Preventiva eliminada con éxito')
                    } else {
                        notyf.error(mensajeSalida);
                    }
                    buscarPreventivas();
                }
            );
        }
    });
}


