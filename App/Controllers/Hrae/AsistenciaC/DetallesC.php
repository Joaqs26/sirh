<?php
include '../librerias.php';

$id_object = $_POST['id_object'];
$asistenciaM = new AsistenciaM();
$row = new row();

if ($id_object != null) {
    $response = $row->returnArray($asistenciaM->editAsistencia($id_object));
    $var = [
        'response' => $response,
    ];
    echo json_encode($var);

} else {
    $response = $asistenciaM->asistenciaIsNUll();
    $var = [
        'response' => $response,
    ];
    echo json_encode($var);
}
