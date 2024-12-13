<?php
include '../librerias.php';

$id_falta = $_POST['id_object'];
$faltaModelM = new FaltaModelM();
$catSelectC = new CatSelectC();
$row = new row();

if ($id_falta != null) {
    $response = $row->returnArray($faltaModelM->listarEditById($id_falta));
    $faltaEstatus = $catSelectC->selectByAllCatalogo($faltaModelM->catFaltaEstatus());
    $faltaTipo = $catSelectC->selectByAllCatalogo($faltaModelM->catFaltaTipo());

    if ($response['id_cat_retardo_tipo'] != '') {
        $faltaTipo = $catSelectC->selectByEditCatalogo($faltaModelM->catFaltaTipo(), $row->returnArrayById($faltaModelM->catFaltaTipoEdit($response['id_cat_retardo_tipo'])));
    }

    if ($response['id_cat_retardo_estatus'] != '') {
        $faltaEstatus = $catSelectC->selectByEditCatalogo($faltaModelM->catFaltaEstatus(), $row->returnArrayById($faltaModelM->catFaltaEstatusEdit($response['id_cat_retardo_estatus'])));
    }

    $var = [
        'response' => $response,
        'faltaEstatus' => $faltaEstatus,
        'faltaTipo' => $faltaTipo,
    ];
    echo json_encode($var);

} else {
    $response = $faltaModelM->listarByNull();
    $faltaEstatus = $catSelectC->selectByAllCatalogo($faltaModelM->catFaltaEstatus());
    $faltaTipo = $catSelectC->selectByAllCatalogo($faltaModelM->catFaltaTipo());
    $var = [
        'response' => $response,
        'faltaEstatus' => $faltaEstatus,
        'faltaTipo' => $faltaTipo,
    ];
    echo json_encode($var);
}
