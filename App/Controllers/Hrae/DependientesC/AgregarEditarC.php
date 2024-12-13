<?php
include '../librerias.php';

$modelDependientesM = new ModelDependientesM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_dependientes_economicos_hraes' => $_POST['id_object']
];

$datos = [
    'nombre' => $_POST['nombre'],
    'curp' => $_POST['curp'],
    'apellido_paterno' => $_POST['apellido_paterno'],
    'apellido_materno' => $_POST['apellido_materno'],
    'id_cat_dependientes_economicos' => $_POST['id_cat_dependientes_economicos'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes']
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($modelDependientesM ->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_dependientes_economicos_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelDependientesM ->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_dependientes_economicos_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

