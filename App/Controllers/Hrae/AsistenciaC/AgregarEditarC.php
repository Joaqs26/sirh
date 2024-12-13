<?php
include '../librerias.php';

$asistenciaM = new AsistenciaM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_asistencia' => $_POST['id_object']
];

$datos = [
    'fecha' => $_POST['fecha'],
    'hora' => $_POST['hora'],
    'dispositivo' => $_POST['dispositivo'],
    'verificacion' => $_POST['verificacion'],
    'estado' => $_POST['estado'],
    'evento' => $_POST['evento'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'id_user' => $_SESSION['id_user'],
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($asistenciaM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_asistencia',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($asistenciaM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_asistencia',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

