<?php
include '../librerias.php';

$preventivasM = new PreventivasM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_preventivas' => $_POST['id_object']
];

if (isset($_POST['id_object'])) {
    if ($preventivasM->eliminarByArray($connectionDBsPro, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_preventivas',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'public.bitacora_hraes');
        echo 'delete';
    }
}
