<?php
include '../../../View/validar_sesion.php';
include '../../../Model/Central/BitacoraM/BitacoraM.php';
include '../../../../conexion.php';
include '../../../Model/Central/CentroTrabajoM/CentroTrabajoM.php';

$model = new modelCentroTrabajoHraes();
$bitacoraM = new BitacoraM();
$tablaCentroTrabajo = 'central.tbl_centro_trabajo_hraes';

$condicion = [
    'id_tbl_centro_trabajo_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])) {
    if ($model->eliminarByArray($connectionDBsPro, $condicion, $tablaCentroTrabajo)) {
        $dataBitacora = [
            'nombre_tabla' => $tablaCentroTrabajo,
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        pg_insert($connectionDBsPro, 'central.bitacora_hraes', $dataBitacora);
        echo 'delete';
    }
}
