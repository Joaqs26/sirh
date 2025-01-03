
var notyf = new Notyf({
    position: {
        x: 'right',
        y: 'top',
    },
    dismissible: true, // Permite que las notificaciones sean cerrables
    duration: 3000, // Duración predeterminada de las notificaciones en milisegundos (opcional)
});

var mensajeSalida = 'Se produjo un error al ejecutar la acción';

$(document).ready(function () {
    buscarAsistencia();
});


function iniciarTablaAsis(busqueda, paginador) { ///INGRESA LA TABLA
    $.ajax({
        type: 'POST',
        url: '../../../../App/View/Central/Asistencias/Asistencias/tabla.php',
        data: {
            busqueda: busqueda,
            paginador: paginador
        },
        success: function (data) {
            $('#tabla_asistencias_').html(data);
        }
    });
}

function buscarAsistencia() { //BUSQUEDA
    let buscarNew = clearElement(buscar_asistencia);
    let buscarlenth = lengthValue(buscarNew);

    if (buscarlenth == 0) {
        iniciarTablaAsis(null, iniciarBusqueda());
    } else {
        iniciarTablaAsis(buscarNew, iniciarBusqueda());
    }
}


function getDetallesAsistencia(id) {
    $.post("../../../../App/Controllers/Central/AsistenciaC/InfoAllC.php", {
        id: id
    },
        function (data) {
            let jsonData = JSON.parse(data);//se obtiene el json
            let response = jsonData.response;

            $("#nombre_ass").val(response[0]);
            $("#rfc_ss").val(response[1]);
            $("#fecha_ss").val(response[2]);
            $("#hora_ss").val(response[3]);
            $("#dispositivo_ss").val(response[4]);
            $("#verificacion_ss").val(response[5]);
            $("#estado_ss").val(response[6]);
            $("#evento_ss").val(response[7]);
        }
    );
    $("#modal_detalles").modal("show");
}

function cerrarDetallesAsis() {
    $("#modal_detalles").modal("hide");
}

function mostrarAgregar() {
    $("#modalAgregarAsistencia").modal("show");
}

function ocultarAgregar() {
    $("#modalAgregarAsistencia").modal("hide");
}

function activeCargaMasiva(){
    $("#modalAgregarAsistencia").modal("hide");
    mostrarModalCargaAsistencia();
}























function agregarEditarDetalles(id_object) { //SE OBTIENEN INFO DE ID SELECCIONADO
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_centro_trabajo");
    titulo.textContent = 'Modificar';
    if (id_object == null) {
        $("#agregar_editar_modal").find("input,textarea,select").val("");
        titulo.textContent = 'Agregar';
    }

    $.post("../../../../App/Controllers/Central/CentroTrabajoC/DetallesC.php", {
        id_object: id_object
    },
        function (data, status) {
            var jsonData = JSON.parse(data);//se obtiene el json
            var entidad = jsonData.entidad;
            var entity = jsonData.response; //Se agrega a emtidad 
            var region = jsonData.region;
            var estatus = jsonData.estatus;

            //Catalogos
            $('#id_cat_entidad').empty();
            $('#id_cat_region').empty();
            $('#id_estatus_centro').empty();
            $('#id_cat_entidad').html(entidad);
            $('#id_cat_region').html(region);
            $('#id_estatus_centro').html(estatus);


            $('#id_cat_entidad').selectpicker('refresh');
            $('#id_cat_region').selectpicker('refresh');
            $('#id_estatus_centro').selectpicker('refresh');
            $('.selectpicker').selectpicker();

            $("#nivel_atencion").val(entity.nivel_atencion);
            $("#nombre").val(entity.nombre);
            $("#clave_centro_trabajo").val(entity.clave_centro_trabajo);
            $("#colonia").val(entity.colonia);
            $("#codigo_postal").val(entity.codigo_postal);
            $("#num_exterior").val(entity.num_exterior);
            $("#num_interior").val(entity.num_interior);
            $("#latitud").val(entity.latitud);
            $("#longitud").val(entity.longitud);
            $("#pais").val(entity.pais);
        }
    );

    $("#agregar_editar_modal").modal("show");
}



function agregarEditarByDb() {
    var id_cat_entidad = $("#id_cat_entidad").val();
    var id_cat_region = $("#id_cat_region").val();
    var id_estatus_centro = $("#id_estatus_centro").val();
    var nombre = $("#nombre").val();
    var clave_centro_trabajo = $("#clave_centro_trabajo").val();
    var colonia = $("#colonia").val();
    var codigo_postal = $("#codigo_postal").val();
    var num_exterior = $("#num_exterior").val();
    var num_interior = $("#num_interior").val();
    var latitud = $("#latitud").val();
    var longitud = $("#longitud").val();
    var id_object = $("#id_object").val();
    var pais = $("#pais").val();

    $.post("../../../../App/Controllers/Central/CentroTrabajoC/AgregarEditarC.php", {
        id_object: id_object,
        id_cat_entidad: id_cat_entidad,
        id_cat_region: id_cat_region,
        id_estatus_centro: id_estatus_centro,
        nombre: nombre,
        clave_centro_trabajo: clave_centro_trabajo,
        colonia: colonia,
        codigo_postal: codigo_postal,
        num_exterior: num_exterior,
        num_interior: num_interior,
        latitud: latitud,
        longitud: longitud,
        pais: pais,
        nivel_atencion: $("#nivel_atencion").val()

    },
        function (data) {

            if (data == 'edit') {
                notyf.success('Centro de trabajo modificado con éxito');
            } else if (data == 'add') {
                notyf.success('Centro de trabajo agregado con éxito');
            } else {
                mensajeError(mensajeSalida);
            }
            $("#agregar_editar_modal").modal("hide");
            buscarCentro();
        }
    );
}

function ocultarModal() {
    $("#agregar_editar_modal").modal("hide");
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
            $.post("../../../../App/Controllers/Central/CentroTrabajoC/EliminarC.php", {
                id_object: id_object
            },
                function (data, status) {
                    if (data == 'delete') {
                        notyf.success('Centro de trabajo eliminado con éxito')
                    } else {
                        messageErrorLarge('La eliminación de un centro de trabajo no debe estar sujeta a dependencias como plazas, empleados, o datos complementarios');
                    }
                    buscarCentro();
                }
            );
        }
    });
}

function convertirAMayusculas(event, inputId) {
    let inputElement = document.getElementById(inputId);
    let texto = event.target.value;
    let textoEnMayusculas = texto.toUpperCase();
    inputElement.value = textoEnMayusculas;
}


function validarNumero(input) {
    input.value = input.value.replace(/[^\d]/g, '');
}







/*
document.addEventListener('DOMContentLoaded', function () {
    tippy('#centro_trabajo_plazas', {
      content: 'Consultas las plazas asignadas al centro de trabajo.',
      theme: 'green',
    });
  });


  document.addEventListener('DOMContentLoaded', function () {
    tippy('#agregar_clue', {
        content: 'Agregar centro de trabajo.',
        theme: 'green',
    });
});
*/