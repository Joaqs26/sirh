<?php
include '../librerias.php';

$modelCorreoM = new ModelCorreoM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_medios_contacto_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($modelCorreoM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_medios_contacto_hraes',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
