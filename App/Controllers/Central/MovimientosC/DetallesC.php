<?php
include '../librerias.php';



$id_object = $_POST['id_object'];
$modelMovimientosM = new ModelMovimientosM();
$catMovimientoM = new CatMovimientoM();
$catSelectC = new CatSelectC();
$modelPlazasHraes = new modelPlazasHraes();
$row = new row();
$catNombramientoM = new CatNombramientoM();
$catNombramientoC = new CatNombramientoC();
$modelPlazasHraes = new modelPlazasHraes();

if ($id_object != null) {///MODIFICAR
    $response = $row->returnArray($modelMovimientosM->listarByEdit($id_object));
    $idMovimiento = $row->returnArrayById($catMovimientoM->listadoIdMovimiento($response['id_tbl_movimientos']));
    $general = $catSelectC->selectByEdit($catMovimientoM->listarByAllGeneral(), $row->returnArrayById($catMovimientoM->listarByIdGeneral($response['id_tbl_movimientos'])));
    $especifico = $catSelectC->selectByEditIX($catMovimientoM->obtenerByAllEspecifico($idMovimiento[0]), $row->returnArrayById($catMovimientoM->obtenerByIdEspecifico($response['id_tbl_movimientos'])));
    $caracter = $catNombramientoC->selectByAll($catNombramientoM->listarByAll());
    $plaza = $catSelectC->selectByEditCatalogo($modelPlazasHraes->plazaVacante(), $row->returnArrayById($modelPlazasHraes->plazaVacanteEdit($response['id_tbl_control_plazas_hraes'])));
    $detallesPlaza = $row->returnArrayById($modelPlazasHraes->infoPlazaCentro($response['id_tbl_control_plazas_hraes']));
    if($response['id_cat_caracter_nombramiento'] != null){
        $caracter = $catNombramientoC->selectById($catNombramientoM->listarByAll(), $row->returnArrayById($catNombramientoM->listarByIdEdit($response['id_cat_caracter_nombramiento'])));
    }
    $var = [
        'response' => $response,
        'general' => $general,
        'especifico' => $especifico,
        'caracter' => $caracter,
        'plaza' => $plaza,
        'contratacion' => $detallesPlaza[1],
        'centroTrabajo' => $detallesPlaza[2],
    ];
    echo json_encode($var);

} else {///AGREGAR
    $response = $modelMovimientosM->listarByNull();
    $general = $catSelectC->selectByAllById($catMovimientoM->listarByAllGeneral(), 2, 0);
    $especifico = $catSelectC->selecStaticByNull();
    $caracter = $catNombramientoC->selectByAll($catNombramientoM->listarByAll());
    $plaza = $catSelectC->selectByAllCatalogo($modelPlazasHraes->plazaVacante());
    $var = [
        'response' => $response,
        'general' => $general,
        'especifico' => $especifico,
        'caracter' => $caracter,
        'plaza' => $plaza,
        'contratacion' => null,
        'centroTrabajo' => null,
    ];
    echo json_encode($var);
}
