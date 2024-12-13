<?php

include '../librerias.php';

$contratacionM = new ContratacionM();
$catSelectC = new CatSelectC();

$id_cat_tipo_trabajador = $_POST['id_cat_tipo_trabajador'];

$contratacion = $catSelectC->selecStaticByNull();

if ($id_cat_tipo_trabajador != '') {
    if (pg_num_rows($contratacionM->listarByAllContratacion($id_cat_tipo_trabajador)) > 0) {
        $contratacion = $catSelectC->selectByAllCatalogo($contratacionM->listarByAllContratacion($id_cat_tipo_trabajador));
    }
}


$raw = [
    'contratacion' => $contratacion,
];
echo json_encode($raw);

