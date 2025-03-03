<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../librerias.php';

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

// Clases instanciadas
$row = new Row();
$bitacoraM = new BitacoraM();
$modelMovimientosM = new ModelMovimientosM();
$catMovimientoM = new CatMovimientoM();
$modelEmpleadosHraes = new modelEmpleadosHraes();
$modelPlazasHraes = new modelPlazasHraes();

// Variables de entrada
$nombreTabla = 'central.tbl_plazas_empleados_hraes';
$movimientoBaja = $_POST['movimientoBaja'];
$movimientoAlta = $_POST['movimientoAlta'];
$movimientoMov = $_POST['movimientoMov'];
$movimiento_general = $_POST['movimiento_general'];
$num_plaza = $_POST['num_plaza'];
$id_cat_situacion_plaza_hraes = $_POST['id_cat_situacion_plaza_hraes'];

// Fecha de movimiento
$fecha_movimiento = !empty($_POST['fecha_movimiento']) ? $_POST['fecha_movimiento'] : $fechaActual;

// Obtener ID de movimiento y validar último movimiento
try {
    $idMovimiento = $row->returnArrayById($catMovimientoM->listadoIdMovimiento($_POST['id_tbl_movimientos']));
    $ultimoMovimientoCount = $row->returnArrayById($modelMovimientosM->countUltimoMovimiento($_POST['id_tbl_empleados_hraes']));
} catch (Exception $e) {
    error_log("Error en consulta de movimientos: " . $e->getMessage());
}

// Determinar ID de Plaza Anterior
$idPlazaA = 0;
if ($ultimoMovimientoCount[0] != 0) {
    try {
        $ultimoIdPlaza = $row->returnArrayById($modelMovimientosM->idPlazaMovimiento($_POST['id_tbl_empleados_hraes']));
        $idPlazaA = $ultimoIdPlaza[0];
    } catch (Exception $e) {
        error_log("Error obteniendo último ID de Plaza: " . $e->getMessage());
    }
}

$id_tbl_control_plazas_hraes = $_POST['id_tbl_control_plazas_hraes'];
if ($movimiento_general == $movimientoBaja) {
    $id_tbl_control_plazas_hraes = $idPlazaA;
}

// Modificar número de empleado
if ($idMovimiento[0] != $movimientoBaja) {
    try {
        $claveCentro = $row->returnArrayById($modelPlazasHraes->claveCentroTrabajo($_POST['id_tbl_control_plazas_hraes']));
        $numEmpleado = $row->returnArrayById($modelEmpleadosHraes->numEmpleado($_POST['id_tbl_empleados_hraes']));
        
        $condicion = ['id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']];
        $datos = ['num_empleado' => trim($numEmpleado[0]) . '-' . trim($claveCentro[0])];

        $modelEmpleadosHraes->editarByArray($connectionDBsPro, $datos, $condicion);
    } catch (Exception $e) {
        error_log("Error modificando número de empleado: " . $e->getMessage());
    }
}

// Guardar información de movimientos
$condicion = ['id_tbl_plazas_empleados_hraes' => $_POST['id_object']];
$datos = [
    'id_tbl_movimientos' => $_POST['id_tbl_movimientos'],
    'fecha_movimiento' => $fecha_movimiento,
    'id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes,
    'fecha_inicio' => $_POST['fecha_inicio'],
    'fecha_termino' => $_POST['fecha_termino'],
    'observaciones' => $_POST['observaciones'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

// Bitácora
$var = ['datos' => $datos, 'condicion' => $condicion];

// Modificar estado de plaza
try {
    modificarPlaza($connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, $movimiento_general, $_POST['id_tbl_control_plazas_hraes'], $idPlazaA, $_POST['id_tbl_empleados_hraes'], $fecha_movimiento, $num_plaza, $id_cat_situacion_plaza_hraes);
} catch (Exception $e) {
    error_log("Error modificando plaza: " . $e->getMessage());
}

// Modificar o agregar movimiento
try {
    if ($_POST['id_object'] != null) {
        if ($modelMovimientosM->editarByArray($connectionDBsPro, $datos, $condicion, $nombreTabla)) {
            echo 'edit';
        }
    } else {
        if ($modelMovimientosM->agregarByArray($connectionDBsPro, $datos, $nombreTabla)) {
            echo 'add';
        }
    }
} catch (Exception $e) {
    error_log("Error guardando movimiento: " . $e->getMessage());
}

///---------------- FUNCIONES AUXILIARES ----------------///

function modificarPlaza($connectionDBsPro, $movimientoBaja, $movimientoAlta, $movimientoMov, $movimiento_general, $idPlaza, $idPlazaAnte, $idEmpleados, $fecha, $num_plaza, $id_cat_situacion_plaza_hraes)
{
    error_log("Ejecutando modificarPlaza");

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
    error_log("Ejecutando actualizarPlaza");

    $model = new modelPlazasHraes();

    $condicion = ['id_tbl_control_plazas_hraes' => $id_tbl_control_plazas_hraes];
    $datos = ['id_cat_tipo_plazas' => $id_cat_plazas];

    if ($id_cat_situacion_plaza_hraes == 0) {
        $datos = [
            'id_cat_tipo_plazas' => $id_cat_plazas,
            'num_plaza' => $num_plaza,
            'id_cat_situacion_plaza_hraes' => 1,
        ];
    }

    try {
        $model->editarByArray($connectionDBsPro, $datos, $condicion);
    } catch (Exception $e) {
        error_log("Error en actualizarPlaza: " . $e->getMessage());
    }
}
