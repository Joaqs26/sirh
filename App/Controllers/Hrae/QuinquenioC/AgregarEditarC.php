<?php
include '../librerias.php';

$modelQuinquenioM = new ModelQuinquenioM();
$bitacoraM = new BitacoraM();


$condicion = [
    'id_ctrl_percepciones_quin_hraes' => $_POST['id_object']
];

$datos = [
    'id_cat_quinquenio' => $_POST['id_cat_quinquenio'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'fecha_registro' => $timestamp,
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelQuinquenioM ->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_percepciones_quin_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelQuinquenioM ->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_percepciones_quin_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

