<?php
include '../librerias.php';

$modelPercepcionesM = new ModelPercepcionesM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_percepciones_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($modelPercepcionesM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_percepciones_hraes',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
