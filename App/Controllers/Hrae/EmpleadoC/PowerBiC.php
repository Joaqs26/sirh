<?php

include '../librerias.php';
include '../../../Model/Hraes/ReporteM/ReporteM.php';

$isSchema = 'public';
$isTableName = $isSchema . '.reporte_Hraes';

$reporteM = new ReporteM();

$bool = false;

$bool = $reporteM->isTruncateTable($isTableName) ? true : false;
if (!$bool) exit($bool);

$bool = $reporteM->isQueryAll($isTableName) ? true : false;
if (!$bool) exit ($bool);

echo $bool;

