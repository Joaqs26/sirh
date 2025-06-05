<?php
include '../librerias.php';

$preventivasM = new IncidenciasM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_incidencias' => $_POST['id_object']
];

if (isset($_POST['id_object'])) {
    if ($preventivasM->eliminarByArray($connectionDBsPro, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'central.ctrl_incidencias',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        echo 'delete';
    }
}
