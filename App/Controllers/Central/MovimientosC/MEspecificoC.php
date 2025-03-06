<?php
include '../librerias.php';

$catSelectC = new CatSelectC(); 
$catMovimientoM = new CatMovimientoM();
$row = new Row();

$movimiento_general = $_POST['movimiento_general'];

if ($movimiento_general != '') {
    $especifico = $catSelectC->selectByAllById($catMovimientoM->obtenerByAllEspecifico($movimiento_general), 1, 0);
    $var = [
        'especifico' => $especifico
    ];
} else {
    $var = [
        'especifico' => $especifico = $catSelectC->selecStaticByNull()
    ];
}
echo json_encode($var);
