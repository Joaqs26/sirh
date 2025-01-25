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

// Variables recibidas del formulario
$nombreTabla = 'public.tbl_plazas_empleados_hraes';
$movimientoBaja = $_POST['movimientoBaja'];
$movimientoAlta = $_POST['movimientoAlta'];
$movimientoMov = $_POST['movimientoMov'];
$movimiento_general = $_POST['movimiento_general'];
$num_plaza = $_POST['num_plaza'];
$id_cat_situacion_plaza_hraes = $_POST['id_cat_situacion_plaza_hraes'];

// Validar fecha de movimiento o asignar la fecha actual
$fecha_movimiento = !empty($_POST['fecha_movimiento']) ? $_POST['fecha_movimiento'] : $fechaActual;

// Obtener información de movimientos
$idMovimiento = $row->returnArrayById($catMovimientoM->listadoIdMovimiento($_POST['id_tbl_movimientos']));
$ultimoMovimientoCount = $row->returnArrayById($modelMovimientosM->countUltimoMovimiento($_POST['id_tbl_empleados_hraes']));

// Determinar la plaza anterior
$idPlazaA = 0;
if ($ultimoMovimientoCount[0] != 0) {
    $ultimoIdPlaza = $row->returnArrayById($modelMovimientosM->idPlazaMovimiento($_POST['id_tbl_empleados_hraes']));
    $idPlazaA = $ultimoIdPlaza[0];
}

// Definir plaza seleccionada o asignar la anterior para movimientos de baja
$id_tbl_control_plazas_hraes = $movimiento_general == $movimientoBaja ? $idPlazaA : $_POST['id_tbl_control_plazas_hraes'];

// Si no es un movimiento de baja, modificar el número de empleado
if ($idMovimiento[0] != $movimientoBaja) {
    $claveCentro = $row->returnArrayById($modelPlazasHraes->claveCentroTrabajo($id_tbl_control_plazas_hraes));
    $numEmpleado = $row->returnArrayById($modelEmpleadosHraes->numEmpleado($_POST['id_tbl_empleados_hraes']));

    $condicionEmpleado = [
        'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']
    ];

    $datosEmpleado = [
        'num_empleado' => trim($numEmpleado[0]) . '-' . trim($claveCentro[0])
    ];

    $modelEmpleadosHraes->editarByArray($connectionDBsPro, $datosEmpleado, $condicionEmpleado);
}

// Datos para la tabla de plazas empleados
$condicionPlaza = [
    'id_tbl_plazas_empleados_hraes' => $_POST['id_object']
];

$datosPlaza = [
    'id_tbl_movimientos' => $_POST['id_tbl_movimientos'],
    'fecha_movimiento' => $fecha_movimiento,
    'id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes,
    'fecha_inicio' => $_POST['fecha_inicio'],
    'fecha_termino' => $_POST['fecha_termino'],
   // 'id_cat_caracter_nombramiento' => $_POST['id_cat_caracter_nombramiento'],
    //'motivo_estatus' => $_POST['motivo_estatus'],
    'observaciones' => $_POST['observaciones'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

// Bitácora
$var = [
    'datos' => $datosPlaza,
    'condicion' => $condicionPlaza
];

// Modificar estatus de plaza
modificarPlaza(
    $connectionDBsPro,
    $movimientoBaja,
    $movimientoAlta,
    $movimientoMov,
    $movimiento_general,
    $id_tbl_control_plazas_hraes,
    $idPlazaA,
    $_POST['id_tbl_empleados_hraes'],
    $fecha_movimiento,
    $num_plaza,
    $id_cat_situacion_plaza_hraes
);

// Guardar o modificar en la tabla
if (!empty($_POST['id_object'])) {
    if ($modelMovimientosM->editarByArray($connectionDBsPro, $datosPlaza, $condicionPlaza, $nombreTabla)) {
        agregarBitacora('MODIFICAR', $var);
        echo 'edit';
    }
} else {
    if ($modelMovimientosM->agregarByArray($connectionDBsPro, $datosPlaza, $nombreTabla)) {
        agregarBitacora('AGREGAR', $var);
        echo 'add';
    }
}

function modificarPlaza($connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, $movimiento_general, $idPlaza, $idPlazaAnte, $idEmpleados, $fecha, $num_plaza, $id_cat_situacion_plaza_hraes)
{
    $vacante = 5;
    $ocupada = 3;
    $congelada = 6;
    $idMovimientoVal = null;

    if ($movimiento_general == $movimientoBaja) {
        $idMovimientoVal = $congelada;
        $idPlaza = $idPlazaAnte;
        $id_cat_situacion_plaza_hraes = 1;
    } elseif ($movimiento_general == $movimientoAlta) {
        $idMovimientoVal = $ocupada;
    } elseif ($movimiento_general == $movimientoMov) {
        $idMovimientoVal = $congelada;
        actualizarPlaza($connectionDBsPro, $idMovimientoVal, $idPlazaAnte, $num_plaza, 1);
        $idMovimientoVal = $ocupada;
    }

    actualizarPlaza($connectionDBsPro, $idMovimientoVal, $idPlaza, $num_plaza, $id_cat_situacion_plaza_hraes);
}

function actualizarPlaza($connectionDBsPro, $id_cat_plazas, $id_tbl_control_plazas_hraes, $num_plaza, $id_cat_situacion_plaza_hraes)
{
    $model = new modelPlazasHraes();
    $condicion = ['id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes];
    $datos = ['id_cat_tipo_plazas' => $id_cat_plazas];

    if ($id_cat_situacion_plaza_hraes == 0) {
        $datos['num_plaza'] = $num_plaza;
        $datos['id_cat_situacion_plaza_hraes'] = 1;
    }

    $model->editarByArray($connectionDBsPro, $datos, $condicion);
}

function agregarBitacora($accion, $var)
{
    global $bitacoraM, $connectionDBsPro, $timestamp;
    $dataBitacora = [
        'nombre_tabla' => 'public.tbl_plazas_empleados_hraes',
        'accion' => $accion,
        'valores' => json_encode($var),
        'fecha' => $timestamp,
        'id_users' => $_SESSION['id_user']
    ];
    $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'public.bitacora_hraes');
}
