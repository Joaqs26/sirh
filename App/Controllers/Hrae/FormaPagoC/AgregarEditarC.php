<?php
include '../librerias.php';

$modelFormaPagoM = new ModelFormaPagoM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_cuenta_clabe_hraes' => $_POST['id_object']
];

$datos = [
    'clabe' => $_POST['clabe'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'id_cat_banco' => $_POST['id_cat_banco'],
    'id_cat_estatus' => $_POST['id_cat_estatus_formato_pago'],
    'id_cat_formato_pago' => 1,
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelFormaPagoM ->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_cuenta_clabe_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelFormaPagoM ->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_cuenta_clabe_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

