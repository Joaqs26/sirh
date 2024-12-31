<?php
include '../librerias.php';

$alertasM = new AlertasM(); // Cambiado a AlertasM
$bitacoraM = new BitacoraM();

$condicion = [
    'id_alerta' => $_POST['id_alerta'] // Cambiado a id_alerta
];

if (isset($_POST['id_alerta'])) { // Cambiado a id_alerta
    if ($alertasM->eliminarByArray($connectionDBsPro, $condicion)) { // Cambiado a alertasM
        $dataBitacora = [
            'nombre_tabla' => 'central.ctrl_alertas', // Cambiado a ctrl_alertas
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'central.bitacora_hraes');
        echo 'delete';
    }
}
