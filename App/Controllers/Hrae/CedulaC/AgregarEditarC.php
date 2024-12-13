<?php
include '../librerias.php';

$modelCedulaM = new modelCedulaM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_cedula_empleados_hraes' => $_POST['id_object']
];

$datos = [
    'cedula_profesional' => $_POST['cedula_profesional'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelCedulaM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_cedula_empleados_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelCedulaM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_cedula_empleados_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

