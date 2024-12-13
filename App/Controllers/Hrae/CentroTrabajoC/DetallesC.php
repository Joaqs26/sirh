<?php

include '../librerias.php';

$row = new Row();
$model = new modelCentroTrabajoHraes();
$catEntidad = new catalogoEntidad();
$catalogoEntidad = new catalogoEntidadC();
$catalogoRegionC = new catalogoRegionC();
$catalogoRegion = new catalogoRegion();
$catalogoEstatus = new catalogoEstatus();
$catalogoEstatusC = new catalogoEstatusC();
$catSelectC = new CatSelectC();
$catZonasEconomicas = new CatZonasEconomicas();
$idZona = $response['id_cat_zonas_tabuladores_hraes'] ?? null;

$id_object = $_POST['id_object'];

if ($id_object != null) {
    $response = $row->returnArray($model->listarByIdEdit($id_object));
    $entidad = $catSelectC->selectByAllCatalogo($catEntidad->selectByAllv2());
    $region = $catSelectC->selectByAllCatalogo($catalogoRegion->listarByAllv2());
    $estatus = $catSelectC->selectByAllCatalogo($catalogoEstatus->listarByAllv2());
    $zona = $catSelectC->selectByAllCatalogo($catZonasEconomicas->selectByAll());

    if ($response['id_cat_region'] != '') {
        $region = $catSelectC->selectByEditCatalogo($catalogoRegion->listarByAllv2(), $row->returnArrayById($catalogoRegion->listarByEditv2($response['id_cat_region'])));
    }
    if ($response['id_estatus_centro'] != '') {
        $estatus = $catSelectC->selectByEditCatalogo($catalogoEstatus->listarByAllv2(), $row->returnArrayById($catalogoEstatus->listarByEditv2($response['id_estatus_centro'])));
    }
    if ($response['id_cat_entidad'] != '') {
        $entidad = $catSelectC->selectByEditCatalogo($catEntidad->selectByAllv2(), $row->returnArrayById($catEntidad->selectByEditv2($response['id_cat_entidad'])));
    }
    if ($response['id_cat_zona_economica'] != '') {
    

        $zona = $catSelectC->selectByEditCatalogo($catZonasEconomicas->selectByAll(), $row->returnArrayById($catZonasEconomicas->selectByEdit($response['id_cat_zona_economica'])));
    }

    $var = [
        'entidad' => $entidad,
        'response' => $response,
        'region' => $region,
        'estatus' => $estatus,
        'zona' => $zona,
    ];
    echo json_encode($var);

} else {
    $entidad = $catSelectC->selectByAllCatalogo($catEntidad->selectByAllv2());
    $region = $catSelectC->selectByAllCatalogo($catalogoRegion->listarByAllv2());
    $estatus = $catSelectC->selectByAllCatalogo($catalogoEstatus->listarByAllv2());
    $zona = $catSelectC->selectByAllCatalogo($catZonasEconomicas->selectByAll());
    $response = $model->listarByNull();
    $var = [
        'entidad' => $entidad,
        'response' => $response,
        'region' => $region,
        'estatus' => $estatus,
        'zona' => $zona,
    ];
    echo json_encode($var);
}

