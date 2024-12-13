<?php
include '../librerias.php';

$incidenciasM = new IncidenciasM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_incidencias' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($incidenciasM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_incidencias',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
