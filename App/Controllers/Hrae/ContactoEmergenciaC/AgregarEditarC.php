<?php
include '../librerias.php';

$modelEmergenciaM = new modelEmergenciaM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_contacto_emergencia_hraes' => $_POST['id_object']
];

$datos = [
    'movil' => $_POST['movil'],
    'nombre' => $_POST['nombre'],
    'primer_apellido' => $_POST['primer_apellido'],
    'segundo_apellido' => $_POST['segundo_apellido'],
    'parentesco' => $_POST['parentesco'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelEmergenciaM ->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_contacto_emergencia_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelEmergenciaM ->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_contacto_emergencia_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

