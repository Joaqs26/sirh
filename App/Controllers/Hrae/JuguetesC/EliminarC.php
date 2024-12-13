<?php
include '../librerias.php';

$modelJuguetesM = new ModelJuguetesM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_juguetes_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($modelJuguetesM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_juguetes_hraes',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
