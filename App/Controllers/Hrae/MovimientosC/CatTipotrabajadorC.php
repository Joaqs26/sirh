<?php
include '../librerias.php';
include_once '../../../../App/Model/Catalogos/CatTipotrabajadorM/CatTipotrabajadorM.php'; // VERIFICA QUE LA RUTA SEA CORRECTA

$catTipotrabajadorM = new CatTipotrabajadorM();
$resultado = $catTipotrabajadorM->listarByAllGeneral();

$tiposTrabajador = [];

while ($row = pg_fetch_assoc($resultado)) {
    $tiposTrabajador[] = $row;
}

// Devolver datos en JSON
echo json_encode($tiposTrabajador);
?>
