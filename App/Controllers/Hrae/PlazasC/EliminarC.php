<?php 
include '../../../../conexion.php';
include '../../../Model/Hraes/PlazasM/PlazasM.php';
include '../../../View/validar_sesion.php';
include '../../../Model/Hraes/BitacoraM/BitacoraM.php';

$model = new modelPlazasHraes();
$bitacoraM = new BitacoraM();
$tablaPlazas = 'public.tbl_control_plazas_hraes';

$condicion = [
    'id_tbl_control_plazas_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($model -> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => $tablaPlazas,
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
