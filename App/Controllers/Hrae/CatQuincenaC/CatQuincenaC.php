<?php

include '../librerias.php';

$catQuincenasM = new CatQuincenasM();
$row = new Row();

$idDate = $_POST['isValue'];

$id_cat_quincenas = null;
$quincena = 'NO RECONOCIDO';
$quincenaPeriodo = 'NO RECONOCIDO';

if ($idDate != '') {
    if (pg_num_rows($catQuincenasM->getInfoQuincena($idDate)) > 0) {
        $isValue = $row->returnArrayById($catQuincenasM->getInfoQuincena($idDate));
        $id_cat_quincenas = $isValue[0];
        $quincena = $isValue[1];
        $quincenaPeriodo = $isValue[2];
    }
}


$var = [
    'id_cat_quincenas' => $id_cat_quincenas,
    'quincena' => $quincena,
    'quincenaPeriodo' => $quincenaPeriodo,
];
echo json_encode($var);