<?php
include '../librerias.php';


$asistenciaM = new AsistenciaM();

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];
$no_dispositivo_ass = $_POST['no_dispositivo_ass'];

$bool = false;

if (pg_num_rows($asistenciaM->validateNoBiometrico($no_dispositivo_ass,$id_tbl_empleados_hraes)) > 0) {
    $bool = true;
}

echo $bool;