<?php
include '../librerias.php';

$modelCapacidadesM = new ModelCapacidadesM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_capacidad_dif_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($modelCapacidadesM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_capacidad_dif_hraes',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
