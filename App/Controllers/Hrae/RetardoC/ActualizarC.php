<?php
include '../librerias.php';

$modelRetardoM = new ModelRetardoM();

$isValue = $modelRetardoM->actualizarRetardos();
$bool = $isValue ? true : false;

echo $bool;
