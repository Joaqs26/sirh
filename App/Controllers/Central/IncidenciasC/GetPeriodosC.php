<?php
include '../librerias.php';

$catDiasM = new CatDiasM();
$row = new row();

$result = $catDiasM->getPeriodos();
$options = '';

while ($periodo = pg_fetch_assoc($result)) {
    $options .= '<option value="' . $periodo["id_cat_periodo"] . '">' . htmlspecialchars($periodo["descripcion"]) . '</option>';
}

echo $options;
