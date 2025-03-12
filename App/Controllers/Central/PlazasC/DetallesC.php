<?php

include '../librerias.php';
include '../../../Model/Central/Catalogos/CatPuestoM/CatPuestoM.php';

$catalogoPlazasM = new catalogoPlazasM();
$catalogoPlazasC = new catalogoPlazasC();
$modelPlazasHraes = new modelPlazasHraes();
$catalogoTipoContratcionHraesC = new catalogoTipoContratcionHraesC();
$catalogoTipoContratacionM = new catalogoTipoContratacionM();
$catalogoUnidadResponsableC = new catalogoUnidadResponsableC();
$cataloUnidadResposableM = new cataloUnidadResposableM();
$catalogoPuestosC = new catalogoPuestosC();
$catalogoPuestoM = new catalogoPuestoM();
$catalogoTabularesC = new catalogoTabularesC();
$catalogoTabularesM = new catalogoTabularesM();
$catalogoNivelesC = new catalogoNivelesC();
$catalogoNivelesM = new catalogoNivelesM();
$catZonasPagoM = new CatZonasPagoM();
$catZonaPagoC = new CatZonaPagoC();
$catSelectC = new CatSelectC();
$modelCentroTrabajoHraes = new modelCentroTrabajoHraes();
$catUnidadAdM = new CatUnidadAdM();
$row = new Row();
$contratacionM = new ContratacionM();

$id_object = $_POST['id_object'];

if ($id_object != null) {

    $entity = $row->returnArray($modelPlazasHraes->listarByIdEdit($id_object));
    $niveles = $row->returnArrayById($catalogoPuestoM->nameOfPuesto($entity['id_cat_puesto_hraes']));

    $plazas = null;
    if (!empty($entity['id_cat_tipo_plazas'])) {
        $plazasData = $row->returnArrayById($catalogoPlazasM->obtenerElemetoById($entity['id_cat_tipo_plazas']));
        $plazas = (!empty($plazasData)) ? $catalogoPlazasC->returnCatPLazasByIdObject($catalogoPlazasM->listarByAll(), $plazasData) : null;
    }

    // ✅ Verificar puesto
    $puesto = null;
    if (!empty($entity['id_cat_puesto_hraes'])) {
        $puestoData = $row->returnArrayById($catalogoPuestoM->editByAllPuesto($entity['id_cat_puesto_hraes']));
        $puesto = (!empty($puestoData)) ? $catSelectC->selectByEditCatalogo($catalogoPuestoM->listarByAllPuesto(), $puestoData) : null;
    }

    // ✅ Verificar puesto específico
    $puesto_especifico = null;
    if (!empty($entity['id_cat_aux_puesto'])) {
        $puestoEspecificoData = $row->returnArrayById($catalogoPuestoM->editSpecificName($entity['id_cat_aux_puesto']));
        $puesto_especifico = (!empty($puestoEspecificoData)) ? $catSelectC->selectByEditCatalogo($catalogoPuestoM->listOfSpecificName($entity['id_cat_puesto_hraes']), $puestoEspecificoData) : null;
    }

    // ✅ Verificar unidad de coordinación
    $unidadCoor = null;
    if (!empty($entity['id_cat_coordinacion'])) {
        $unidadCoorData = $row->returnArrayById($catUnidadAdM->editOfCatCoordinacion($entity['id_cat_coordinacion']));
        $unidadCoor = (!empty($unidadCoorData)) ? $catSelectC->selectByEditCatalogo($catUnidadAdM->listOfCatCoordinacion(), $unidadCoorData) : null;
    }

    // ✅ Verificar unidad administrativa
    $unidadAdmin = null;
    if (!empty($entity['id_cat_unidad'])) {
        $unidadAdminData = $row->returnArrayById($catUnidadAdM->editOfCatUnidad($entity['id_cat_unidad']));
        $unidadAdmin = (!empty($unidadAdminData)) ? $catSelectC->selectByEditCatalogo($catUnidadAdM->lisOfCatUnidad(), $unidadAdminData) : null;
    }

    // ✅ Verificar tabulares
    $tabulares = null;
    if (!empty($entity['id_cat_tabulares'])) {
        $tabularesData = $row->returnArrayById($catalogoTabularesM->listarById($entity['id_cat_tabulares']));
        $tabulares = (!empty($tabularesData)) ? $catSelectC->selectByEditCatalogo($catalogoTabularesM->listarByAll(), $tabularesData) : null;
    }

    // ✅ Verificar programa
    $programa = null;
    if (!empty($entity['id_cat_tipo_programa'])) {
        $programaData = $row->returnArrayById($contratacionM->listarByEditPrograma($entity['id_cat_tipo_programa']));
        $programa = (!empty($programaData)) ? $catSelectC->selectByEditCatalogo($contratacionM->listarByAllPrograma(), $programaData) : null;
    }

    // ✅ Verificar contratación
    $contratacion = null;
    if (!empty($entity['id_cat_tipo_contratacion']) && !empty($entity['id_cat_tipo_trabajador'])) {
        $contratacionData = $row->returnArrayById($contratacionM->listarByEditContratacion($entity['id_cat_tipo_contratacion']));
        $contratacion = (!empty($contratacionData)) ? $catSelectC->selectByEditCatalogo($contratacionM->listarByAllContratacion($entity['id_cat_tipo_trabajador']), $contratacionData) : null;
    }

    // ✅ Inicializar `$response` para evitar errores
    if (!isset($response)) {
        $response = [];
    }

    // ✅ Generar JSON con validaciones
    $raw = [
        'entity' => $entity,
        'niveles' => 'NIVEL',
        'zona' => $zona[0] ?? null,
        'plazas' => $plazas ?: null,
        'puesto' => $puesto ?: null,
        'puesto_especifico' => $puesto_especifico ?: null,
        'unidadCoor' => $unidadCoor ?: null,
        'unidadAdmin' => $unidadAdmin ?: null,
        'tabulares' => $tabulares ?: null,
        'programa' => $programa ?: null,
        'contratacion' => $contratacion ?: null
    ];

    echo json_encode($raw);

} else { 
    // ✅ Si no hay ID, asignar valores por defecto como null
    $raw = [
        'entity' => null,
        'niveles' => 'NIVEL',
        'zona' => null,
        'plazas' => null,
        'puesto' => null,
        'puesto_especifico' => null,
        'unidadCoor' => null,
        'unidadAdmin' => null,
        'tabulares' => null,
        'programa' => null,
        'contratacion' => null
    ];

    echo json_encode($raw);
}
?>
