<?php
include '../librerias.php';

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

$CatTipotrabajadorM = new CatTipotrabajadorM();


///ESTANCIAS DE CLASES 
$row = new Row();
$bitacoraM = new BitacoraM();
$modelMovimientosM = new ModelMovimientosM();
$catMovimientoM = new CatMovimientoM();
$modelEmpleadosHraes = new modelEmpleadosHraes();
$modelPlazasHraes = new modelPlazasHraes();

/// VARIABLES DE MODEL JS
$nombreTabla = 'central.tbl_plazas_empleados_hraes';
$movimientoBaja = $_POST['movimientoBaja'];
$movimientoAlta = $_POST['movimientoAlta'];
$movimientoMov = $_POST['movimientoMov'];
$movimiento_general = $_POST['movimiento_general'];
$num_plaza = $_POST['num_plaza'];
$id_cat_situacion_plaza_hraes = $_POST['id_cat_situacion_plaza_hraes'];
$id_cat_tipo_trabajador = isset($_POST['id_cat_tipo_trabajador']) ? $_POST['id_cat_tipo_trabajador'] : null;

// Validar si no hay una fecha de movimiento enviada y establecer la fecha actual
$fecha_movimiento = !empty($_POST['fecha_movimiento']) ? $_POST['fecha_movimiento'] : $fechaActual;

/// SE OBTIENE EL MOVIMIENTO GENERAL
$idMovimiento = $row->returnArrayById($catMovimientoM->listadoIdMovimiento($_POST['id_tbl_movimientos']));
$ultimoMovimientoCount = $row->returnArrayById($modelMovimientosM->countUltimoMovimiento($_POST['id_tbl_empleados_hraes']));

$idPlazaA = 0; 
if ($ultimoMovimientoCount[0] != 0) { 
    $ultimoIdPlaza = $row->returnArrayById($modelMovimientosM->idPlazaMovimiento($_POST['id_tbl_empleados_hraes']));
    $idPlazaA = $ultimoIdPlaza[0]; 
}

$id_tbl_control_plazas_hraes = $_POST['id_tbl_control_plazas_hraes'];
if ($movimiento_general == $movimientoBaja) { 
    $id_tbl_control_plazas_hraes = $idPlazaA; 
}

if ($idMovimiento[0] != $movimientoBaja) { 
    $claveCentro = $row->returnArrayById($modelPlazasHraes->claveCentroTrabajo($_POST['id_tbl_control_plazas_hraes'])); 
    $numEmpleado = $row->returnArrayById($modelEmpleadosHraes->numEmpleado($_POST['id_tbl_empleados_hraes'])); 

    $condicion = [
        'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']
    ];

    $datos = [
        'num_empleado' => trim($numEmpleado[0]) . '-' . trim($claveCentro[0]), 
    ];
    $modelEmpleadosHraes->editarByArray($connectionDBsPro, $datos, $condicion);
}

$condicion = [ 
    'id_tbl_plazas_empleados_hraes' => $_POST['id_object']
];

$datos = [ 
    'id_tbl_movimientos' => $_POST['id_tbl_movimientos'],
    'fecha_movimiento' => $fecha_movimiento, 
    'id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes,
    'fecha_inicio' => $_POST['fecha_inicio'],
    'fecha_termino' => $_POST['fecha_termino'],
    'observaciones' => $_POST['observaciones'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

if ($movimiento_general == $movimientoAlta) {
    $datos['id_cat_tipo_trabajador'] = $id_cat_tipo_trabajador;
}

/// BITÁCORA
$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

/// MODIFICAR ESTATUS DE PLAZA    
modificarPlaza($connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, $movimiento_general, $_POST['id_tbl_control_plazas_hraes'], $idPlazaA, $_POST['id_tbl_empleados_hraes'], $fecha_movimiento, $num_plaza, $id_cat_situacion_plaza_hraes);
if ($_POST['id_object'] != null) { 
    if ($modelMovimientosM->editarByArray($connectionDBsPro, $datos, $condicion, $nombreTabla)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.tbl_plazas_empleados_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        echo 'edit';
    }
} else { 
    if ($modelMovimientosM->agregarByArray($connectionDBsPro, $datos, $nombreTabla)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.tbl_plazas_empleados_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        echo 'add';
    }



}




?>
