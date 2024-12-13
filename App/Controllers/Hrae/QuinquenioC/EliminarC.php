<?php
include '../librerias.php';

$modelQuinquenioM = new ModelQuinquenioM();
$bitacoraM = new BitacoraM();

$condicion = [
    'id_ctrl_percepciones_quin_hraes' => $_POST['id_object']
];

if (isset($_POST['id_object'])){
    if ($modelQuinquenioM-> eliminarByArray($connectionDBsPro, $condicion)){
        $dataBitacora = [
            'nombre_tabla' => 'public.ctrl_percepciones_quin_hraes',
            'accion' => 'ELIMINAR',
            'valores' => json_encode($condicion),
            'fecha' => $timestamp,
            'id_users' => $_SESSION['id_user']
        ];
        $bitacoraM->agregarByArray($connectionDBsPro,$dataBitacora,'public.bitacora_hraes');
        echo 'delete';
    }
} 
