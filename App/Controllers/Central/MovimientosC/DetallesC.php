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
$catTipotrabajadorM = new CatTipotrabajadorM();

if ($id_object != null) { // ✅ MODIFICAR
    $response = $row->returnArray($modelMovimientosM->listarByEdit($id_object));

    $idMovimiento = $row->returnArrayById(
        $catMovimientoM->listadoIdMovimiento($response['id_tbl_movimientos'])
    );
    $idMovimientoGeneral = $idMovimiento[1] ?? null;

    $general = $catSelectC->selectByEdit(
        $catMovimientoM->listarByAllGeneral(),
        $row->returnArrayById($catMovimientoM->listarByIdGeneral($response['id_tbl_movimientos']))
    );

    $especifico = $catSelectC->selectByEditIX(
        $catMovimientoM->obtenerByAllEspecifico($idMovimiento[0]),
        $row->returnArrayById($catMovimientoM->obtenerByIdEspecifico($response['id_tbl_movimientos']))
    );

    $caracter = $catNombramientoC->selectByAll($catNombramientoM->listarByAll());

    $plaza = $catSelectC->selectByEditCatalogo(
        $modelPlazasHraes->plazaVacante(),
        $row->returnArrayById($modelPlazasHraes->plazaVacanteEdit($response['id_tbl_control_plazas_hraes']))
    );

    $detallesPlaza = $row->returnArrayById(
        $modelPlazasHraes->infoPlazaCentro($response['id_tbl_control_plazas_hraes'])
    );

    if (!empty($response['id_cat_caracter_nombramiento'])) {
        $caracter = $catNombramientoC->selectById(
            $catNombramientoM->listarByAll(),
            $row->returnArrayById($catNombramientoM->listarByIdEdit($response['id_cat_caracter_nombramiento']))
        );
    }
    $tipotrabaja =  $catTipotrabajadorM->listarByAllGeneral();
    if (!empty($response['id_cat_tipo_trabajador'])) {
        $tipotrabaja = $catSelectC->selectByEditCatalogo(
            $catTipotrabajadorM->listarByAllGeneral(),
            $row->returnArrayById($catTipotrabajadorM->listarByIdGeneral($response['id_cat_tipo_trabajador']))
        );
    }

    // ✅ Si movimiento general es ALTA, incluir tipo de trabajador
    $tipoTrabajador = $response['id_cat_tipo_trabajador'] ?? null;
    $descripcionTipoTrabajador = $response['descripcion'] ?? null;

    // Obtener id_cat_tipo_trabajador y descripcion
    $tipoTrabajadorData = $modelPlazasHraes->idTipoTrabajador($response['id_tbl_empleados_hraes']);
    $idTipoTrabajador = $tipoTrabajadorData['id_cat_tipo_trabajador'] ?? null;
    $descripcionTipoTrabajador = $tipoTrabajadorData['descripcion'] ?? null;

    echo json_encode([
        'response' => $response,
        'general' => $general,
        'especifico' => $especifico,
        'caracter' => $caracter,
        'plaza' => $plaza,
        'contratacion' => $detallesPlaza[1],
        'centroTrabajo' => $detallesPlaza[2],
        'tipo_trabajador' => $tipoTrabajador,
        'descripcion_tipo_trabajador' => $tipotrabaja,
        'id_cat_tipo_trabajador' => $idTipoTrabajador,
        'id_movimiento_general' => $idMovimientoGeneral
        
    ]);

} else { // ✅ NUEVO
    $response = $modelMovimientosM->listarByNull();
    $general = $catSelectC->selectByAllById($catMovimientoM->listarByAllGeneral(), 2, 0); // por defecto Movimiento
    $especifico = $catSelectC->selecStaticByNull();
    $caracter = $catNombramientoC->selectByAll($catNombramientoM->listarByAll());
    $plaza = $catSelectC->selectByAllCatalogo($modelPlazasHraes->plazaVacante());

    echo json_encode([
        'response' => $response,
        'general' => $general,
        'especifico' => $especifico,
        'caracter' => $caracter,
        'plaza' => $plaza,
        'contratacion' => null,
        'centroTrabajo' => null,
        'tipo_trabajador' => null,
        'descripcion_tipo_trabajador' => null,
        'id_movimiento_general' => null,
        'id_cat_tipo_trabajador' => null
    ]);
}