<?php
include '../librerias.php';

$modelEspecialidadM = new ModelEspecialidadM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_especialidad_hraes' => $_POST['id_object']
];

$datos = [
    'id_cat_especialidad_hraes' => $_POST['id_cat_especialidad_hraes'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'cedula' => $_POST['cedula']
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelEspecialidadM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_especialidad_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelEspecialidadM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_especialidad_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

