<?php
include '../librerias.php';

$faltaModelM = new FaltaModelM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_faltas' => $_POST['id_object']
];

if (isset($_POST['id_object'])) {
    if ($faltaModelM->eliminarByArray($connectionDBsPro, $condicion)) {
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_faltas',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro, $dataBitacora, 'public.bitacora_hraes');
        echo 'delete';
    }
}
