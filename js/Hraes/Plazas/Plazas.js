var notyf = new Notyf({
    position: {
        x: 'right',
        y: 'top',
    },
    dismissible: true, // Permite que las notificaciones sean cerrables
    duration: 3000, // Duración predeterminada de las notificaciones en milisegundos (opcional)
});


var id_tbl_centro_trabajo_hraes = document.getElementById("id_tbl_centro_trabajo_hraes").value;
var mensajeSalida = 'Se produjo un error al ejecutar la acción';

$(document).ready(function () {
    buscarPlaza();
    buscarInfoCentroTrabajo();
});

function buscarPlaza() { //BUSQUEDA
    let buscarNew = clearElement(buscar);
    let buscarlenth = lengthValue(buscarNew);

    if (buscarlenth == 0) {
        iniciarPlazas(id_tbl_centro_trabajo_hraes, null, iniciarBusqueda())
    } else {
        iniciarPlazas(id_tbl_centro_trabajo_hraes, buscarNew, iniciarBusqueda())
    }
}

function iniciarPlazas(id_tbl_centro_trabajo_hraes, busqueda, paginador) {
    $.ajax({
        type: 'POST',
        url: '../../../../App/View/Hraes/Plazas/tabla.php',
        data: {
            busqueda: busqueda,
            paginador: paginador,
            id_tbl_centro_trabajo_hraes: id_tbl_centro_trabajo_hraes
        },
        success: function (data) {
            $('#tabla_plazas').html(data);
        }
    });
}

function agregarEditarDetalles(id_object) { //SE OBTIENEN INFO DE ID SELECCIONADO
    let checkbox = document.getElementById("id_cat_situacion_plaza_hraes");
    let checkbox_disabled = document.getElementById("checkbox_disabled");

    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_plazas");
    titulo.textContent = 'Modificar';

    if (id_object == null) {
        $("#agregar_editar_modal").find("input,textarea,select").val("");
        titulo.textContent = 'Agregar';
    }
    $.post("../../../../App/Controllers/Hrae/PlazasC/DetallesC.php", {
        id_object: id_object,
        id_tbl_centro_trabajo_hraes: id_tbl_centro_trabajo_hraes
    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);//se obtiene el json
            let entity = jsonData.entity; //Se agrega a emtidad 
            let plazas = jsonData.plazas;
            let puesto = jsonData.puesto;
            let niveles = jsonData.niveles;
            let pago = jsonData.pago;
            let is_unidadAdmin_ = jsonData.unidadAdmin;
            let is_unidadCoor = jsonData.unidadCoor;
            let is_nomEspecifico = jsonData.nomEspecifico;
            let is_puestoCategoria = jsonData.puestoCategoria;
            let is_zona = jsonData.zona;
            let is_programa = jsonData.programa;
            let is_trabajador = jsonData.trabajador;
            let is_contratacion = jsonData.contratacion;
            let is_caracterNom = jsonData.caracterNom;

            $('#id_cat_unidad').empty();
            $('#id_cat_unidad').html(is_unidadAdmin_);
            $('#id_cat_coordinacion').empty();
            $('#id_cat_coordinacion').html(is_unidadCoor);
            $('#id_cat_aux_puesto').empty();
            $('#id_cat_aux_puesto').html(is_nomEspecifico);
            $('#id_cat_plazas').empty();
            $('#id_cat_plazas').html(plazas);
            $('#id_tbl_zonas_pago').empty();
            $('#id_tbl_zonas_pago').html(pago);
            $('#id_cat_puesto_hraes').empty();
            $('#id_cat_puesto_hraes').html(puesto);
            $('#id_cat_categoria_puesto').empty();
            $('#id_cat_categoria_puesto').html(is_puestoCategoria);
            $('#id_cat_tipo_programa').empty();
            $('#id_cat_tipo_programa').html(is_programa);
            $('#id_cat_tipo_trabajador').empty();
            $('#id_cat_tipo_trabajador').html(is_trabajador);
            $('#id_cat_tipo_contratacion').empty();
            $('#id_cat_tipo_contratacion').html(is_contratacion);
            $('#id_cat_caracter_nombramiento').empty();
            $('#id_cat_caracter_nombramiento').html(is_caracterNom);

            $('#id_cat_tipo_trabajador').selectpicker('refresh');
            $('#id_cat_tipo_contratacion').selectpicker('refresh');
            $('#id_cat_tipo_programa').selectpicker('refresh');
            $('#id_cat_categoria_puesto').selectpicker('refresh');
            $('#id_cat_unidad').selectpicker('refresh');
            $('#id_cat_coordinacion').selectpicker('refresh');
            $('#id_cat_aux_puesto').selectpicker('refresh');
            $('#id_cat_plazas').selectpicker('refresh');
            $('#id_tbl_zonas_pago').selectpicker('refresh');
            $('#id_cat_puesto_hraes').selectpicker('refresh');
            $('#id_cat_caracter_nombramiento').selectpicker('refresh');
            $('.selectpicker').selectpicker();

            $("#id_zona_pagadora_clue").val(is_zona);
            $("#id_cat_niveles_hraes").val(niveles);
            $("#num_plaza").val(entity.num_plaza);
            $("#is_fecha_inicio").val(entity.fecha_inicio);
            $("#is_fecha_fin").val(entity.fecha_fin);
            $("#id_tbl_centro_trabajo_hraes_aux").val(entity.id_tbl_centro_trabajo_hraes);

            /*
            let bool = entity.id_cat_situacion_plaza_hraes != 1 ? true : false;
            checkbox.checked = bool;
            checkbox_disabled.disabled = !bool;
            checkbox_disabled_num_plaza.disabled = !bool;
            */
        }
    );

    $("#agregar_editar_modal").modal("show");
}

function agregarEditarByDb() {
    /*
    let id_cat_situacion_plaza_hraes = document.getElementById("id_cat_situacion_plaza_hraes");
    let id_cat_situacion_plaza_hraes_x = id_cat_situacion_plaza_hraes.checked ? 0 : 1;
    */

    let id_tbl_centro_trabajo_hraes_aux = $("#id_tbl_centro_trabajo_hraes_aux").val();
    let id_object = $("#id_object").val();

    if (id_tbl_centro_trabajo_hraes == null) {
        id_tbl_centro_trabajo_hraes_aux = id_tbl_centro_trabajo_hraes;
    }

    if (id_object == '') {
        id_tbl_centro_trabajo_hraes_aux = id_tbl_centro_trabajo_hraes;
    }

    $.post("../../../../App/Controllers/Hrae/PlazasC/AgregarEditarC.php", {
        id_object: id_object,
        id_tbl_centro_trabajo_hraes: id_tbl_centro_trabajo_hraes_aux,

        num_plaza: $("#num_plaza").val(),
        id_cat_plazas: $("#id_cat_plazas").val(),
        id_cat_situacion_plaza_hraes: 1, //$("#id_cat_situacion_plaza_hraes").val(),
        id_cat_puesto_hraes: $("#id_cat_puesto_hraes").val(),
        id_cat_aux_puesto: $("#id_cat_aux_puesto").val(),
        id_cat_categoria_puesto: $("#id_cat_categoria_puesto").val(),
        id_cat_tipo_trabajador: $("#id_cat_tipo_trabajador").val(),
        id_cat_tipo_contratacion: $("#id_cat_tipo_contratacion").val(),
        id_cat_tipo_programa: $("#id_cat_tipo_programa").val(),
        id_cat_unidad: $("#id_cat_unidad").val(),
        id_cat_coordinacion: $("#id_cat_coordinacion").val(),
        id_cat_caracter_nombramiento: $("#id_cat_caracter_nombramiento").val(),
        fecha_inicio: $("#is_fecha_inicio").val(),
        fecha_fin: $("#is_fecha_fin").val(),
    },
        function (data) {
            if (data == 'edit') {
                notyf.success('Plaza modificada con éxito');
            } else if (data == 'add') {
                notyf.success('Plaza agregada con éxito');
            } else {
                notyf.error(mensajeSalida);
            }
            $("#agregar_editar_modal").modal("hide");
            buscarPlaza();
            buscarInfoCentroTrabajo();
        }
    );
}

function ocultarModal() {
    $("#agregar_editar_modal").modal("hide");
}

function ocultarModalDetalles() {
    $("#mostar_detalles_modal").modal("hide");
}

function eliminarEntity(id_object) {
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
            $.post("../../../../App/Controllers/Hrae/PlazasC/EliminarC.php", {
                id_object: id_object
            },
                function (data) {
                    console.log(data);
                    if (data == 'delete') {
                        notyf.success('Plaza eliminada con éxito');
                    } else {
                        messageErrorLarge('La eliminación de una plaza no debe estar sujeta a dependencias de empleados, o datos complementarios');
                    }
                    buscarPlaza();
                    buscarInfoCentroTrabajo();
                }
            );
        }
    });
}


function buscarInfoCentroTrabajo() {
    if (id_tbl_centro_trabajo_hraes != '') {
        let clvResult = document.getElementById("clvResult");
        let nombreResult = document.getElementById("nombreResult");
        let cpResult = document.getElementById("cpResult");
        let colonia_ = document.getElementById("colonia_");
        let region_ = document.getElementById("region_");
        let entidad_ = document.getElementById("entidad_");
        let pais_ = document.getElementById("pais_");
        let plazas_ = document.getElementById("plazas_");

        $.post("../../../../App/Controllers/Hrae/PlazasC/InfoCentroC.php", {
            id_tbl_centro_trabajo_hraes: id_tbl_centro_trabajo_hraes,
        },
            function (data) {
                console.log(data);
                let jsonData = JSON.parse(data);//se obtiene el json

                clvResult.textContent = jsonData.clave;
                nombreResult.textContent = jsonData.nombre;
                cpResult.textContent = jsonData.codigo_postal;
                colonia_.textContent = jsonData.colonia;
                region_.textContent = jsonData.region;
                entidad_.textContent = jsonData.entidad;
                pais_.textContent = jsonData.pais;
                plazas_.textContent = jsonData.plazas;
            }
        );
    }
}


function detallesPlazaModal(id_tbl_control_plazas_hraes) {
    $.post("../../../../App/Controllers/Hrae/PlazasC/DetallesEntityC.php", {
        id_tbl_control_plazas_hraes: id_tbl_control_plazas_hraes,
    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);//se obtiene el json
            let entity = jsonData.entity;
            let empleado = jsonData.empleado;

            $("#espe_clabe").val(entity[5]);
            $("#espe_entidad").val(entity[7]);
            $("#espe_codigo_postal").val(entity[8]);
            $("#espe_unidad_rep").val(entity[3]);
            $("#espe_codigo_postal").val(entity[8]);
            $("#espe_nombre").val(entity[6]);

            listarTablaHistori(id_tbl_control_plazas_hraes);
            $("#modal_detallas_plazas").modal("show");
        }
    );
}

function detallesPlazaModalOcultar() {
    $("#modal_detallas_plazas").modal("hide");
}



function listarTablaHistori(id_tbl_control_plazas_hraes) {
    $.post("../../../../App/View/Hraes/Plazas/tablaHistoria.php", {
        id_tbl_control_plazas_hraes: id_tbl_control_plazas_hraes,
    },
        function (data) {
            console-log(data);
            $('#tabla_historia_plaza_empleado_ix').html(data);
        }
    );
}

function concatNombre(nombre, primerApellido, segundoApellido) {
    if (nombre != null) {
        return nombre + ' ' + primerApellido + ' ' + segundoApellido;
    } else {
        return 'Sin registro.';
    }
}


function validarNumero(input) {
    input.value = input.value.replace(/[^\d]/g, '');
}

function abrirModalAdd() {
    $("#exampleModal").modal("show");
}

function cerrarModalAdd() {
    $("#exampleModal").modal("hide");
}