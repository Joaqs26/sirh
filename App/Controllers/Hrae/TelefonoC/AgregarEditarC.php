<?php
include '../librerias.php';

$modelTelefonoM = new ModelTelefonoM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_telefono_hraes' => $_POST['id_object']
];

$datos = [
    'movil' => $_POST['movil'],
    'id_cat_estatus' => $_POST['id_cat_estatus'],
    'telefono' => $_POST['telefono'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelTelefonoM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_telefono_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelTelefonoM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_telefono_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

