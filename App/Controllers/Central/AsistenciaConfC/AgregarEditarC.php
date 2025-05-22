<?php
include '../librerias.php';

$bitacoraM = new BitacoraM();
$asistenciaM = new AsistenciaM();

$idExludio = 4; //Id excluido de catalago de estatus
$fecha_fin = null;
$fecha_inicio = null;
$boolAss = false;
$boolJor = false;

if ($idExludio == $_POST['id_cat_asistencia_ubicacion']) {
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin = $_POST['fecha_fin'] ?? null;

}

$fecha_fin = $_POST['fecha_fin'] ?? null;
$fecha_inicio = $_POST['fecha_inicio']?? null;

$condicion = [
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']
];

$datos = [
    'observaciones' => $_POST['observaciones'],
    'no_dispositivo' => $_POST['no_dispositivo'],
    'id_cat_asistencia_ubicacion' => $_POST['id_cat_asistencia_ubicacion'],
    'id_cat_asistencia_estatus' => $_POST['id_cat_asistencia_estatus'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'fecha_inicio' => $fecha_inicio,
    'fecha_fin' => $fecha_fin
];

$datos_jornada = [
    'id_cat_jornada_turno' => $_POST['id_cat_jornada_turno'],
    'id_cat_jornada_dias' => $_POST['id_cat_jornada_dias'],
    'id_cat_jornada_horario' => $_POST['id_cat_jornada_horario'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

$varJor = [
    'datos' => $datos_jornada,
    'condicion' => $condicion
];

// Obtener el id_cat_asistencia_config a partir del id_cat_jornada_horario
$idHorario = $_POST['id_cat_jornada_horario'];
$result = pg_query($connectionDBsPro, "SELECT id_cat_asistencia_config FROM central.cat_asistencia_config WHERE id_cat_asistencia_config = '$idHorario' LIMIT 1");
if ($row = pg_fetch_assoc($result)) {
    $datos['id_cat_asistencia_config'] = $row['id_cat_asistencia_config'];
} else {
    $datos['id_cat_asistencia_config'] = null; // o maneja el error como prefieras
}

if ($_POST['id_ctrl_asistencia_info'] != null) { //Modificar
    if ($asistenciaM->editAsistenciaInfoDB($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.ctrl_asistencia_info',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        $boolAss = true;
    }
} else { //Agregar
    if ($asistenciaM->addAsistenciaInfoDB($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.ctrl_asistencia_info',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        $boolAss = true;
    }
}

if ($_POST['id_ctrl_jornada'] != null) { //Modificar
    if ($asistenciaM->editJornadaInfoDB($connectionDBsPro, $datos_jornada, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.ctrl_jornada',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($varJor),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        $boolJor = true;
    }
} else { //Agregar
    if ($asistenciaM->addJornadaInfoDB($connectionDBsPro, $datos_jornada)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.ctrl_jornada',
            'accion' => 'AGREGAR',
            'valores' => json_encode($varJor),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        $boolJor = true;
    }
}

if ($boolAss && $boolJor) {
    echo true;
} else {
    echo false;
}
