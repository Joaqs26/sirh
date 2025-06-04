<?php
include '../librerias.php';

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

// Instancias de clases
$row = new Row();
$bitacoraM = new BitacoraM();
$modelMovimientosM = new ModelMovimientosM();
$catMovimientoM = new CatMovimientoM();
$modelEmpleadosHraes = new modelEmpleadosHraes();
$modelPlazasHraes = new modelPlazasHraes();
$modelMovimientosM = new ModelMovimientosM();

// Variables recibidas desde el formulario
$nombreTabla = 'central.tbl_plazas_empleados_hraes';
$movimientoBaja = $_POST['movimientoBaja'] ?? null;
$movimientoAlta = $_POST['movimientoAlta'] ?? null;
$movimientoMov = $_POST['movimientoMov'] ?? null;
$movimiento_general = $_POST['movimiento_general'] ?? null;
$num_plaza = $_POST['num_plaza'] ?? null;
$id_cat_situacion_plaza_hraes = $_POST['id_cat_situacion_plaza_hraes'] ?? null;
$id_cat_tipo_trabajador = $_POST['id_cat_tipo_trabajador'] ?? null; 

// Validar si hay fecha de movimiento enviada, de lo contrario, usar la fecha actual
$fecha_movimiento = !empty($_POST['fecha_movimiento']) ? $_POST['fecha_movimiento'] : $fechaActual;

// Obtener el movimiento general
$idMovimiento = $row->returnArrayById($catMovimientoM->listadoIdMovimiento($_POST['id_tbl_movimientos']));
$ultimoMovimientoCount = $row->returnArrayById($modelMovimientosM->countUltimoMovimiento($_POST['id_tbl_empleados_hraes']));

$idPlazaA = 0;
if ($ultimoMovimientoCount[0] != 0) { 
    $ultimoIdPlaza = $row->returnArrayById($modelMovimientosM->idPlazaMovimiento($_POST['id_tbl_empleados_hraes']));
    $idPlazaA = $ultimoIdPlaza[0]; 
}

// Manejo del ID de la plaza seleccionada
$id_tbl_control_plazas_hraes = $_POST['id_tbl_control_plazas_hraes'] ?? null;
if ($movimiento_general == $movimientoBaja) { 
    $id_tbl_control_plazas_hraes = $idPlazaA; 
}

// ✅ Obtener el valor actual de `num_empleado`
$numEmpleadoActual = $row->returnArrayById($modelEmpleadosHraes->numEmpleado($_POST['id_tbl_empleados_hraes']));

if ($idMovimiento[0] != $movimientoBaja && empty($numEmpleadoActual[0])) { // ✅ Solo modificar si está vacío
    $claveCentro = $row->returnArrayById($modelPlazasHraes->claveCentroTrabajo($id_tbl_control_plazas_hraes));
    $numEmpleado = trim($claveCentro[0]);

    $condicion = [
        'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']
    ];

    $datosEmpleado = [
        'num_empleado' => $numEmpleado // ✅ Solo inserta si está vacío
    ];
    $modelEmpleadosHraes->editarByArray($connectionDBsPro, $datosEmpleado, $condicion);
}

// Condición para la actualización en la tabla
$condicion = [
    'id_tbl_plazas_empleados_hraes' => $_POST['id_object'] ?? null
];

// Datos a insertar en la tabla
$datos = [
    'id_tbl_movimientos' => $_POST['id_tbl_movimientos'],
    'fecha_movimiento' => $fecha_movimiento,
    'id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes,
    'fecha_inicio' => $_POST['fecha_inicio'],
    'fecha_termino' => $_POST['fecha_termino'],
    'observaciones' => $_POST['observaciones'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

// ✅ Solo agregar `id_cat_tipo_trabajador` si el movimiento es ALTA
if ($movimiento_general == $movimientoAlta) {
    $datos['id_cat_caracter_nombramiento'] = $id_cat_tipo_trabajador;
}

// Guardar en la bitácora
$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

// Modificar estatus de la plaza
modificarPlaza(
    $connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, 
    $movimiento_general, $id_tbl_control_plazas_hraes, $idPlazaA, 
    $_POST['id_tbl_empleados_hraes'], $fecha_movimiento, $num_plaza, 
    $id_cat_situacion_plaza_hraes
);

// Insertar o modificar
if ($_POST['id_object'] != null) { 
    if ($modelMovimientosM->editarByArray($connectionDBsPro, $datos, $condicion, $nombreTabla)) {
        registrarBitacora($bitacoraM, $connectionDBsPro, 'MODIFICAR', $var);
        echo 'edit';
    }
} else { 
    if ($modelMovimientosM->agregarByArray($connectionDBsPro, $datos, $nombreTabla)) {
        registrarBitacora($bitacoraM, $connectionDBsPro, 'AGREGAR', $var);
        echo 'add';
    }
}

/**
 * Función para registrar en la bitácora.
 */
function registrarBitacora($bitacoraM, $connectionDBsPro, $accion, $var) {
    $dataBitacora = [
        'nombre_tabla' => 'central.tbl_plazas_empleados_hraes',
        'accion' => $accion,
        'valores' => json_encode($var),
        'fecha' => date('Y-m-d H:i:s'),
        'id_users' => $_SESSION['id_user']
    ];
    $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
}

/**
 * Función para modificar estatus de la plaza
 */
function modificarPlaza($connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, $movimiento_general, $idPlaza, $idPlazaAnte, $idEmpleados, $fecha, $num_plaza, $id_cat_situacion_plaza_hraes) {
    $vacante = 5;
    $ocupada = 3;
    $congelada = 6;
    $idMovimientoVal = null;

    if ($movimiento_general == $movimientoBaja) { 
        $idMovimientoVal = $congelada;
        $idPlaza = $idPlazaAnte;
        $id_cat_situacion_plaza_hraes = 1;
    } else if ($movimiento_general == $movimientoAlta) {
        $idMovimientoVal = $ocupada;
    } else if ($movimiento_general == $movimientoMov) {
        $idMovimientoVal = $congelada;
        actualizarPlaza($connectionDBsPro, $idMovimientoVal, $idPlazaAnte, $num_plaza, 1);
        $idMovimientoVal = $ocupada;
    }

    actualizarPlaza($connectionDBsPro, $idMovimientoVal, $idPlaza, $num_plaza, $id_cat_situacion_plaza_hraes);
}


function actualizarPlaza($connectionDBsPro, $id_cat_plazas, $id_tbl_control_plazas_hraes, $num_plaza, $id_cat_situacion_plaza_hraes) {
    $model = new modelPlazasHraes();

    $condicion = [
        'id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes
    ];

    $datos = [
        'id_cat_tipo_plazas' => $id_cat_plazas
    ];

    if ($id_cat_situacion_plaza_hraes == 0) {
        $datos = [
            'id_cat_tipo_plazas' => $id_cat_plazas,
            'num_plaza' => $num_plaza,
            'id_cat_situacion_plaza_hraes' => 1,
        ];
    }

    $model->editarByArray($connectionDBsPro, $datos, $condicion);
}