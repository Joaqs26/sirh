<?php
include '../../../../conexion.php';
include '../../../Model/Hraes/EmpleadosM/EmpleadosM.php';
include '../../../Model/Hraes/BitacoraM/BitacoraM.php';
include '../../../View/validar_sesion.php';

$model = new modelEmpleadosHraes();
$bitacoraM = new BitacoraM();
$tablaEmpleados = 'public.tbl_empleados_hraes';

$condicion = [
    'id_tbl_empleados_hraes' => $_POST['id_object']
];

$datos = [
    'nombre' => $_POST['nombre'],
    'rfc' => $_POST['rfc'],
    'primer_apellido' => $_POST['primer_apellido'],
    'curp' => $_POST['curp'],
    'segundo_apellido' => $_POST['segundo_apellido'],
    'nss' => $_POST['nss'],
    'id_cat_estado_civil' => $_POST['id_cat_estado_civil'],
    //'id_cat_genero_hraes' => $_POST['id_cat_genero'],
    'num_empleado' => $_POST['num_empleado'],
    'id_cat_pais_nacimiento' => $_POST['id_cat_pais_nacimiento'],
    'id_cat_estado_nacimiento' => $_POST['id_cat_estado_nacimiento'],
    'nacionalidad' => $_POST['nacionalidad'],
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

if ($_POST['id_object'] != null) { //Modificar
    if ($model->editarByArray($connectionDBsPro, $datos, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => $tablaEmpleados,
            'accion' => 'MODIFICAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'edit';
    }

} else { //Agregar
    if ($model->agregarByArray($connectionDBsPro, $datos)) {
        $dataBitacora = [
            'nombre_tabla' => $tablaEmpleados,
            'accion' => 'AGREGAR',
            'valores' => json_encode($var),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'add';
    }
}


