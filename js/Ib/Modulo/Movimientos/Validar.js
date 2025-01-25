/// VARIABLES DE CATALOGO TBL MOVIMIENTOS
var movimientoBaja = 3;
var movimientoAlta = 1;
var movimientoMov = 2;

function validarAgregar() {
    let id_object = document.getElementById('id_object').value;
    if (id_object) {
        if (validarAccion()) {
            validarMovimiento();
        }
    } else {
        validarMovimiento();
    }
}

function validarMovimiento() {
    let movimiento_general = document.getElementById('movimiento_general').value;
    let id_tbl_movimientos = document.getElementById('id_tbl_movimientos').value;
    let fecha_movimiento = document.getElementById('fecha_movimiento').value;
    let id_tbl_control_plazas_hraes = document.getElementById('id_tbl_control_plazas_hraes').value;
    let fecha_inicio = document.getElementById('fecha_inicio').value;

    if (validarData(movimiento_general, 'Movimiento general')) { /// VALIDACIÓN INICIAL
        if (movimiento_general != movimientoBaja) { /// ALTA O MOVIMIENTO
            if (
                validarData(id_tbl_movimientos, 'Movimiento específico') &&
                validarData(fecha_movimiento, 'Fecha de movimiento') &&
                validarData(id_tbl_control_plazas_hraes, 'Núm. Plaza') &&
                validarData(fecha_inicio, 'Fecha de inicio')
            ) {
                validarUltimoMovimiento(movimiento_general, id_object, fecha_movimiento, id_tbl_control_plazas_hraes);
            }
        } else { /// BAJA
            if (
                validarData(id_tbl_movimientos, 'Movimiento específico') &&
                validarData(fecha_movimiento, 'Fecha de movimiento')
            ) {
                limpiarBaja();
                validarUltimoMovimiento(movimiento_general, id_object, fecha_movimiento, id_tbl_control_plazas_hraes);
            }
        }
    }
}

/// FUNCIÓN PARA VALIDAR EL ÚLTIMO MOVIMIENTO
function validarUltimoMovimiento(movimiento_general, id_object, fecha_movimiento, num_plaza_new, situacionPlaza) {
    $.post("../../../../App/Controllers/Central/MovimientosC/UltimoMovimientoC.php", {
        movimiento_general: movimiento_general || '',
        fecha_movimiento: fecha_movimiento || '',
        movimientoBaja: movimientoBaja,
        id_object: id_object || '',
        id_tbl_empleados_hraes: id_tbl_empleados_hraes || '',
        movimientoAlta: movimientoAlta,
        movimientoMov: movimientoMov,
        num_plaza_new: num_plaza_new || '',
        situacionPlaza: situacionPlaza || '',
    },  
    function (data) {
        console.log(data);
        let jsonData = JSON.parse(data);
        let bool = jsonData.bool;
        let mensaje = jsonData.mensaje;

        if (bool) {
            guardarMovimiento();
        } else {
            messageLarge(mensaje);
        }
    });
}
    
/// EVENTO AL CAMBIAR EL NUMERO DE PLAZA
document.getElementById("id_tbl_control_plazas_hraes").addEventListener("change", function () {
    let id_tbl_control_plazas_hraes = this.value;
    $.post(
        "../../../../App/Controllers/Central/MovimientosC/NumPlazaC.php",
        {
            id_tbl_control_plazas_hraes: id_tbl_control_plazas_hraes,
        },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            let contratacion = jsonData.contratacion;
            let centroTrabajo = jsonData.centroTrabajo;

            $('#tipo_contratacion_mx').val(contratacion);
            $('#centro_trabajo_mx').val(centroTrabajo);
        }
    );
});

/// EVENTO AL CAMBIAR MOVIMIENTO GENERAL
document.getElementById("movimiento_general").addEventListener("change", function () {
    let movimiento_general = this.value;
    if (movimiento_general == movimientoBaja) {
        ocultarContenido('ocultar_model');
    } else {
        mostrarContenido('ocultar_model');
    }

    $.post(
        "../../../../App/Controllers/Central/MovimientosC/MEspecificoC.php",
        {
            movimiento_general: movimiento_general,
        },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);
            $('#id_tbl_movimientos').html(jsonData.especifico);
        }
    );
});

/// FUNCIONES AUXILIARES
function ocultarContenido(text) {
    let x = document.getElementById(text);
    x.style.display = "none";
}

function mostrarContenido(text) {
    let x = document.getElementById(text);
    x.style.display = "block";
}

function messageLarge(text) {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: text,
    });
}

function limpiarBaja() { /// LIMPIAR CAMPOS PARA MOVIMIENTO DE BAJA
    $('#id_tbl_control_plazas_hraes').val('');
    $('#tipo_contratacion_mx').val('');
    $('#centro_trabajo_mx').val('');
    $('#fecha_inicio').val('');
    $('#fecha_termino').val('');
    $('#id_cat_caracter_nombramiento').val('');
}
