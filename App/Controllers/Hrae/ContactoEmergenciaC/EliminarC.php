<?php
include '../librerias.php';

$modelEmergenciaM = new ModelEmergenciaM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_contacto_emergencia_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($modelEmergenciaM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_contacto_emergencia_hraes',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
