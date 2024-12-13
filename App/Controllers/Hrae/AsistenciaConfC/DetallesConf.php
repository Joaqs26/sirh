<?php

include '../librerias.php';

//Is class
$asistenciaM = new AsistenciaM();
$row = new Row();

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];


$noDispositivo_ = '-';
$ubicacion_ = '-';
$estatus_ = '-';
$observaciones_ = '-';
$turno_ = '-';
$horario_ = '-';
$jornada_ass = '-';

if (pg_num_rows($asistenciaM->listOfAsistencia($id_tbl_empleados_hraes)) > 0) {
    $result = $row->returnArrayById($asistenciaM->listOfAsistencia($id_tbl_empleados_hraes));
    $noDispositivo_ = $result[1];
    $ubicacion_ = $result[2];
    $estatus_ = $result[3];
    $observaciones_ = $result[4];
}

if (pg_num_rows($asistenciaM->listOfJornada($id_tbl_empleados_hraes)) > 0) {
    $result = $row->returnArrayById($asistenciaM->listOfJornada($id_tbl_empleados_hraes));
    $turno_ = $result[1];
    $horario_ = $result[3];
    $jornada_ass = $result[2];
}


$var = [
    'noDispositivo_' => $noDispositivo_,
    'ubicacion_' => $ubicacion_,
    'estatus_' => $estatus_,
    'observaciones_' => $observaciones_,
    'turno_' => $turno_,
    'horario_' => $horario_,
    'jornada_ass' => $jornada_ass,
];
echo json_encode($var);
