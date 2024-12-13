<?php
include '../librerias.php';

$preventivasM = new PreventivasM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_preventivas' => $_POST['id_object']
];

$datos = [
    'no_oficio' => $_POST['no_oficio'],
    'observaciones' => $_POST['observaciones'],
    'fecha_inicio' => $_POST['fecha_inicio'],
    'fecha_fin' => $_POST['fecha_fin'],
    'id_cat_preventivas' => $_POST['id_cat_preventivas'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'id_user' => $_SESSION['id_user'],
    'fecha_usuario' => $isNow,
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($preventivasM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_preventivas',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($preventivasM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_preventivas',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'public.bitacora_hraes');
        echo 'add';
    }
}

