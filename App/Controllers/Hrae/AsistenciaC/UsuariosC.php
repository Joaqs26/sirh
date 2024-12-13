<?php
include '../librerias.php';

$id_object = $_POST['id'];
$asistenciaM = new AsistenciaM();
$row = new row();

$name = '-';

if ($id_object != '' || isset($id_object) || $id_object != null) {
    if (pg_num_rows($asistenciaM->getNameOfUser($id_object)) > 0) {
        $nameResult = $row->returnArrayById($asistenciaM->getNameOfUser($id_object));
        $name = $nameResult[0];
    }
}

echo $name;



