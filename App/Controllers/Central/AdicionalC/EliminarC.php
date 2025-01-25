<?php 
include '../../../../conexion.php';
include '../../../Model/Central/EmpleadosM/EmpleadosM.php';

$model = new modelEmpleadosHraes();

$condicion = [
    'id_tbl_empleados_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($model -> eliminarByArray($connectionDBsPro, $condicion)){
        echo 'delete';
    }
} 
