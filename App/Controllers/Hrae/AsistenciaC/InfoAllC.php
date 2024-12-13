<?php
include '../librerias.php';

$id = $_POST['id'];
$asistenciaM = new AsistenciaM();
$row = new row();

if ($id != null) {
    $response = $row->returnArrayById($asistenciaM->getInfoAsistencia($id));
    $var = [
        'response' => $response,
    ];
    echo json_encode($var);
}