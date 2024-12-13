<?php
include '../librerias.php';

$adicionalM = new AdicionalM();
$bitacoraM = new BitacoraM();
$tablaEmpleados = 'tbl_empleados_hraes';
$tablaAdicional = 'public.ctrl_adic_emp_hraes';

$condicion = [
    'id_ctrl_adic_emp_hraes' => $_POST['id_ctrl_adic_emp_hraes']
];

$datos = [
    'fecha_expedicion' => $_POST['fecha_expedicion'],
    'fecha_ingreso_gob_fed' => $_POST['fecha_ingreso_gob_fed'],
    'vigencia_del' => $_POST['vigencia_del'],
    'vigencia_al' => $_POST['vigencia_al'],
    'funciones' => $_POST['funciones'],
    'antiguedad' => $_POST['antiguedad'],
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_ctrl_adic_emp_hraes'] != null) { //Modificar
    if ($adicionalM->editarByArray($connectionDBsPro,$tablaAdicional,$datos,$condicion)) {
        $dataBitacora = [
            'nombre_tabla' => $tablaAdicional,
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($adicionalM->agregarByArray($connectionDBsPro,$tablaAdicional,$datos)) {
        $dataBitacora = [
            'nombre_tabla' => $tablaAdicional,
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}


