<?php
include '../librerias.php';

$modelDomicilioM = new ModelDomicilioM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_tbl_domicilios_hraes' => $_POST['id_tbl_domicilios']
];

$datos = [
    'id_tbl_empleados_hraes' => $_POST['id_tbl_empleados_hraes'],
    'codigo_postal2' => $_POST['codigo_postal2'],
    'codigo_postal1' => $_POST['codigo_postal1'],
    'entidad1' => $_POST['entidad1'],
    'municipio1' => $_POST['municipio1'],
    'colonia1' => $_POST['colonia1'],
    'calle1' => $_POST['calle1'],
    'num_exterior1' => $_POST['num_exterior1'],
    'num_interior1' => $_POST['num_interior1']
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_tbl_domicilios'] != null) { //Modificar
    if ($modelDomicilioM->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.tbl_domicilios_hraes',
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($modelDomicilioM->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.tbl_domicilios_hraes',
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}


