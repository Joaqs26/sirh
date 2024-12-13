<?php
include '../librerias.php';

$faltaModelM = new FaltaModelM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_faltas' => $_POST['id_object']
];

$datos = [
    'fecha_desde' => $_POST['fecha_desde'],
    'fecha_hasta' => $_POST['fecha_hasta'],
    'fecha_registro' => $_POST['fecha_registro'],
    'codigo_certificacion' => $_POST['codigo_certificacion'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'observaciones' => $_POST['observaciones'],
    'es_por_retardo' => $_POST['es_por_retardo'],
    'id_cat_retardo_tipo' => $_POST['id_cat_retardo_tipo'],
    'id_cat_retardo_estatus' => $_POST['id_cat_retardo_estatus'],
    'fecha' => $_POST['fecha'],
    'hora' => $_POST['hora'],
    'cantidad' => $_POST['cantidad']
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($faltaModelM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_faltas',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($faltaModelM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_faltas',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'public.bitacora_hraes');
        echo 'add';
    }
}

