<?php
include '../librerias.php';

$modelJuguetesM = new ModelJuguetesM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_juguetes_hraes' => $_POST['id_object']
];

$datos = [
    'id_ctrl_dependientes_economicos_hraes' => $_POST['id_ctrl_dependientes_economicos_hraes'],
    'id_cat_fecha_juguetes' => $_POST['id_cat_fecha_juguetes'],
    'id_cat_estatus_juguetes' => $_POST['id_cat_estatus_juguetes'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelJuguetesM ->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_juguetes_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelJuguetesM ->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_juguetes_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

