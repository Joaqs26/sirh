<?php
include '../librerias.php';

$incidenciasM = new IncidenciasM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_incidencias' => $_POST['id_object']
];

$datos = [
    'fecha_inicio' => $_POST['fecha_inicio'],
    'fecha_fin' => $_POST['fecha_fin'],
    'fecha_captura' => $_POST['fecha_captura'],
    'hora' => $_POST['hora'],
    'observaciones' => $_POST['observaciones'],
    'id_cat_incidencias' => $_POST['id_cat_incidencias'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'id_user' => $_SESSION['id_user'],
    'es_mas_de_un_dia' => $_POST['es_mas_de_un_dia'],
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($incidenciasM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_incidencias',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($incidenciasM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_incidencias',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}

