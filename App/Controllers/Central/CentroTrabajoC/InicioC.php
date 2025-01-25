<?php

include '../../../Model/Central/CentroTrabajoM/CentroTrabajoM.php';
include '../../../Controllers/Central/GlobalC/ArrayC.php';
include '../../../../conexion.php';

$modelCentroTrabajoHraes = new modelCentroTrabajoHraes();
$row = new Row();

$totalCT = $row->returnArrayById($modelCentroTrabajoHraes->listarAllCount());
$rCentro = $row->returnArrayById($modelCentroTrabajoHraes->listarByRegion(1)); //Regional centro
$rSur = $row->returnArrayById($modelCentroTrabajoHraes->listarByRegion(2)); //Regional sur
$rNorte = $row->returnArrayById($modelCentroTrabajoHraes->listarByRegion(3)); //Regional norte
$rMetropolitano = $row->returnArrayById($modelCentroTrabajoHraes->listarByRegion(4)); //Regional metropolitana
$rCorporativo = $row->returnArrayById($modelCentroTrabajoHraes->listarByRegion(5)); //Regional corporativo

$var = [
    'totalCT' => $totalCT[0],
    'rCentro' => $rCentro[0],
    'rSur' => $rSur[0],
    'rNorte' => $rNorte[0],
    'rMetropolitano' => $rMetropolitano[0],
    'rCorporativo' => $rCorporativo[0],
];
echo json_encode($var);