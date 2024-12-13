
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
    buscarCentro();
});


function iniciarTabla(busqueda, paginador) { ///INGRESA LA TABLA
    $.ajax({
        type: 'POST',
        url: '../../../../App/View/Hraes/CentroTrabajo/tabla.php',
        data: {
            busqueda: busqueda,
            paginador: paginador
        },
        success: function (data) {
            $('#tabla_centro_trabajo').html(data);
        }
    });
}

function buscarCentro() { //BUSQUEDA
    let buscarNew = clearElement(buscar);
    let buscarlenth = lengthValue(buscarNew);

    if (buscarlenth == 0) {
        iniciarTabla(null, iniciarBusqueda());
    } else {
        iniciarTabla(buscarNew, iniciarBusqueda());
    }
}

function agregarEditarDetalles(id_object) { //SE OBTIENEN INFO DE ID SELECCIONADO
    $("#id_object").val(id_object);
    let titulo = document.getElementById("titulo_centro_trabajo");
    titulo.textContent = 'Modificar';
    if (id_object == null) {
        $("#agregar_editar_modal").find("input,textarea,select").val("");
        titulo.textContent = 'Agregar';
    }

    $.post("../../../../App/Controllers/Hrae/CentroTrabajoC/DetallesC.php", {
        id_object: id_object
    },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            let entidad = jsonData.entidad;
            let entity = jsonData.response;
            let region = jsonData.region;
            let estatus = jsonData.estatus;
            let zona = jsonData.zona;

            //Catalogos
            $('#id_cat_entidad').empty();
            $('#id_cat_region').empty();
            $('#id_estatus_centro').empty();
            $('#id_cat_zona_economica').empty();
            $('#id_cat_entidad').html(entidad);
            $('#id_cat_zona_economica').html(zona);
            $('#id_cat_region').html(region);
            $('#id_estatus_centro').html(estatus);


            $('#id_cat_entidad').selectpicker('refresh');
            $('#id_cat_region').selectpicker('refresh');
            $('#id_estatus_centro').selectpicker('refresh');
            $('#id_cat_zona_economica').selectpicker('refresh');
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
    $.post("../../../../App/Controllers/Hrae/CentroTrabajoC/AgregarEditarC.php", {
        id_object: $("#id_object").val(),
        nombre: $("#nombre").val(),
        clave_centro_trabajo: $("#clave_centro_trabajo").val(),
        colonia: $("#colonia").val(),
        num_exterior: $("#num_exterior").val(),
        num_interior: $("#num_interior").val(),
        latitud: $("#latitud").val(),
        longitud: $("#longitud").val(),
        longitud: $("#longitud").val(),
        codigo_postal: $("#codigo_postal").val(),
        pais: $("#pais").val(),
        id_cat_entidad: $("#id_cat_entidad").val(),
        id_cat_zona_economica: $("#id_cat_zona_economica").val(),
        id_cat_region: $("#id_cat_region").val(),
        id_estatus_centro: $("#id_estatus_centro").val(),
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
            $.post("../../../../App/Controllers/Hrae/CentroTrabajoC/EliminarC.php", {
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