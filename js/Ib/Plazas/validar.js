function validar() {

    let num_plaza = document.getElementById('num_plaza').value.trim();
    let id_cat_plazas = document.getElementById('id_cat_plazas').value.trim();
    //  let id_cat_situacion_plaza_hraes = document.getElementById('id_cat_situacion_plaza_hraes').value.trim();
    let id_cat_puesto_hraes = document.getElementById('id_cat_puesto_hraes').value.trim();
    let id_cat_aux_puesto = document.getElementById('id_cat_aux_puesto').value.trim();
    let id_cat_categoria_puesto = document.getElementById('id_cat_categoria_puesto').value.trim();
    //  let id_cat_tipo_trabajador = document.getElementById('id_cat_tipo_trabajador').value.trim();
    let id_cat_tipo_contratacion = document.getElementById('id_cat_tipo_contratacion').value.trim();
    let id_cat_tipo_programa = document.getElementById('id_cat_tipo_programa').value.trim();
    let id_cat_unidad = document.getElementById('id_cat_unidad').value.trim();
    let id_cat_coordinacion = document.getElementById('id_cat_coordinacion').value.trim();
    let id_object = document.getElementById('id_object').value.trim();

    if (validarData(num_plaza, 'Número de plaza') &&
        validarData(id_cat_plazas, 'Tipo de plaza') &&
        validarData(id_cat_puesto_hraes, 'Puesto') &&
        validarData(id_cat_aux_puesto, 'Puesto especifico') &&
        validarData(id_cat_categoria_puesto, 'Categoria de puesto') &&
        // validarData(id_cat_tipo_trabajador, 'Trabajador') &&
        validarData(id_cat_tipo_contratacion, 'Contratación') &&
        validarData(id_cat_tipo_programa, 'Programa') &&
        validarData(id_cat_unidad, 'Unidad administrativa') &&
        validarData(id_cat_coordinacion, 'Coordinación') &&
        caracteresCount('Número de plaza', 10, num_plaza)
    ) {
        if (id_object.length === 0) {
            agregarEditarByDb();
        } else {
            validarEstatusPlaza(id_cat_plazas, id_object);
        }
    }
}


function validarEstatusPlaza(id_cat_plazas, id_object) {
    $.post("../../../../App/Controllers/Central/PlazasC/ValidarEstatusC.php", {
        id_cat_plazas: id_cat_plazas,
        id_object: id_object
    },
        function (data) {
            let jsonData = JSON.parse(data);
            let message = jsonData.message;
            let bool = jsonData.bool;

            if (bool) {
                notyf.error(message);
            } else {
                agregarEditarByDb();
            }
        }
    );
}

$(document).ready(function () {
    $('#id_cat_puesto_hraes').on('change', function () {
        let id_cat_puesto_hraes = $(this).val();
        $.post("../../../../App/Controllers/Central/PlazasC/GetNivel.php", {
            id_cat_puesto_hraes: id_cat_puesto_hraes,
        },
            function (data) {
                let jsonData = JSON.parse(data);
                let message = jsonData.message;
                let puestoEsp = jsonData.puestoEsp;
                let categoriaPuesto = jsonData.categoriaPuesto;

                $('#id_cat_niveles_hraes').val(message);

                $('#id_cat_aux_puesto').empty();
                $('#id_cat_aux_puesto').html(puestoEsp);
                $('#id_cat_categoria_puesto').empty();
                $('#id_cat_categoria_puesto').html(categoriaPuesto);

                $('#id_cat_categoria_puesto').selectpicker('refresh');
                $('#id_cat_aux_puesto').selectpicker('refresh');
            }
        );
    });
});


$(document).ready(function () {
    $('#id_cat_aux_puesto').on('change', function () {
        let id_cat_aux_puesto = $(this).val();
        let id_cat_puesto_hraes = document.getElementById('id_cat_puesto_hraes').value.trim();

        $.post("../../../../App/Controllers/Central/PlazasC/GetCatalogo.php", {
            id_cat_puesto_hraes: id_cat_puesto_hraes,
            id_cat_aux_puesto: id_cat_aux_puesto
        },
            function (data) {
                let jsonData = JSON.parse(data);
                let categoriaResp = jsonData.categoriaResp;

                $('#id_cat_categoria_puesto').empty();
                $('#id_cat_categoria_puesto').html(categoriaResp);
                $('#id_cat_categoria_puesto').selectpicker('refresh');
            }
        );
    });
});


$(document).ready(function () {
    $('#id_cat_tipo_trabajador').on('change', function () {
        let id_cat_tipo_trabajador = $(this).val();

        $.post("../../../../App/Controllers/Central/PlazasC/GetContratacion.php", {
            id_cat_tipo_trabajador: id_cat_tipo_trabajador,
        },
            function (data) {
                let jsonData = JSON.parse(data);
                let contratacion = jsonData.contratacion;

                $('#id_cat_tipo_contratacion').empty();
                $('#id_cat_tipo_contratacion').html(contratacion);
                $('#id_cat_tipo_contratacion').selectpicker('refresh');
            }
        );
    });
});
function Tabulacion(id_object) {
    console.log(id_object);
    console.log('entro 123');
    $.post("../../../../App/Controllers/Central/PlazasC/Tabulador.php", {
        id: id_object,
    },
        function (data) {
            console.log(data);
            $("#Tabulacion").modal("show");
        }
    );

    /*
    $.ajax({
        url: '../../../../App/Model/Hraes/PlazasM/PlazasM.php', // Reemplaza con la ruta real a tu controlador PHP
        type: 'POST',
        data: { id: id_object },
        dataType: 'json',
        success: function (response) {
            console.log('response');
            console.log(response);
            // Asumiendo que la respuesta es un objeto JSON con las propiedades correspondientes
            $('#codigo_puesto_actual').val(response.codigo_puesto_actual);
            $('#sueldo_base').val(response.sueldo_base);
            $('#ayuda_gastos_actualizacion').val(response.ayuda_gastos_actualizacion);
            $('#compensacion_garantizada').val(response.compensacion_garantizada);
            $('#asignacion_bruta').val(response.asignacion_bruta);
            $('#compensacion_servicios').val(response.compensacion_servicios);
            $('#compensacion_polivalencia').val(response.compensacion_polivalencia);
            $('#total_bruto_mensual').val(response.total_bruto_mensual);
            $('#total_neto_mensual').val(response.total_neto_mensual);
            $('#sueldo_quincenal_neto').val(response.sueldo_quincenal_neto);

            // Mostrar el modal
            $('#Tabulacion').modal('show');
        },

    });*/
}
