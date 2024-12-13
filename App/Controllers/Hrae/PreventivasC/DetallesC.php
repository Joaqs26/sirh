<?php
include '../librerias.php';

$catQuincenasM = new CatQuincenasM();
$id_object = $_POST['id_object'];
$preventivasM = new PreventivasM();
$row = new row();
$catSelectC = new CatSelectC();

if ($id_object != null) {
    $response = $row->returnArray($preventivasM->getDetails($id_object));

    $preventivas = $catSelectC->selectByAllCatalogo($preventivasM->listarCatPreventivas());
    if ($response['id_cat_preventivas'] != '') {
        $preventivas = $catSelectC->selectByEditCatalogo($preventivasM->listarCatPreventivas(), $row->returnArrayById($preventivasM->editCatPreventivas($response['id_cat_preventivas'])));
    }

    $quincena = 'Quincena';
    $periodo = 'Periodo de quincena';
    if ($response['fecha_inicio'] != '') {
        $isValue = $row->returnArrayById($catQuincenasM->getInfoQuincena($response['fecha_inicio']));
        $quincena = $isValue[1];
        $periodo = $isValue[2];
    }

    $var = [
        'response' => $response,
        'preventivas' => $preventivas,
        'quincena' => $quincena,
        'periodo' => $periodo,
    ];
    echo json_encode($var);

} else {
    $response = $preventivasM->listarByNull();
    $preventivas = $catSelectC->selectByAllCatalogo($preventivasM->listarCatPreventivas());
    $quincena = 'Quincena';
    $periodo = 'Periodo de quincena';

    $var = [
        'response' => $response,
        'preventivas' => $preventivas,
        'quincena' => $quincena,
        'periodo' => $periodo,
    ];
    echo json_encode($var);
}
