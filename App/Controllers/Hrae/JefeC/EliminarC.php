<?php
include '../librerias.php';

$modelJefeM = new ModelJefeM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_jefe_inmediato_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($modelJefeM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_jefe_inmediato_hraes',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
