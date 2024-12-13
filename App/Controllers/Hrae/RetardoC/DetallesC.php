<?php
include '../librerias.php';

$catQuincenasM = new CatQuincenasM();
$id_objectDependiente = $_POST['id_object'];
$modelRetardoM = new ModelRetardoM();
$catRetardosM = new CatRetardosM();
$catSelectC = new CatSelectC();
$row = new row();

$quincena = 'Quincena';
$periodoQuincena = 'Periodo de quincena';
$catRetardoTipo = $catSelectC->selectByAllCatalogo($catRetardosM->listadoRetardoTipo());
$catRetardoEstatus = $catSelectC->selectByAllCatalogo($catRetardosM->listadoRetardoEstatus());

if ($id_objectDependiente != null) {
    $response = $row->returnArray($modelRetardoM->listarEditById($id_objectDependiente));

    if ($response['id_cat_retardo_tipo'] != '') {
        $catRetardoTipo = $catSelectC->selectByEditCatalogo($catRetardosM->listadoRetardoTipo(), $row->returnArrayById($catRetardosM->editRetardoTipo($response['id_cat_retardo_tipo'])));
    }

    if ($response['id_cat_retardo_estatus'] != '') {
        $catRetardoEstatus = $catSelectC->selectByEditCatalogo($catRetardosM->listadoRetardoEstatus(), $row->returnArrayById($catRetardosM->editRetardoEstatus($response['id_cat_retardo_estatus'])));
    }

    if ($response['fecha'] != '') {
        if (pg_num_rows($catQuincenasM->getInfoQuincena($response['fecha'])) > 0) {
            $isValue = $row->returnArrayById($catQuincenasM->getInfoQuincena($response['fecha']));
            $quincena = $isValue[1];
            $periodoQuincena = $isValue[2];
        }
    }

    $var = [
        'response' => $response,
        'catRetardoTipo' => $catRetardoTipo,
        'catRetardoEstatus' => $catRetardoEstatus,
        'quincena' => $quincena,
        'periodoQuincena' => $periodoQuincena,
    ];
    echo json_encode($var);

} else {
    $response = $modelRetardoM->listarByNull();

    $var = [
        'response' => $response,
        'catRetardoTipo' => $catRetardoTipo,
        'catRetardoEstatus' => $catRetardoEstatus,
        'quincena' => $quincena,
        'periodoQuincena' => $periodoQuincena,
    ];
    echo json_encode($var);
}
