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
    $zona = $row->returnArrayById($catalogoPuestoM->getEntity($id_object));

    // ✅ Verificar Plazas
    $plazas = $catalogoPlazasC->returnCatPlazas($catalogoPlazasM->listarByAll());
    if (!empty($entity['id_cat_tipo_plazas'])) {
        $plazasData = $row->returnArrayById($catalogoPlazasM->obtenerElemetoById($entity['id_cat_tipo_plazas']));
        $plazas = (!empty($plazasData)) ? $catalogoPlazasC->returnCatPLazasByIdObject($catalogoPlazasM->listarByAll(), $plazasData) : $plazas;
    }

    // ✅ Verificar Puesto
    $puesto = $catSelectC->selectByAllCatalogo($catalogoPuestoM->listarByAllPuesto());
    if (!empty($entity['id_cat_puesto_hraes'])) {
        $puestoData = $row->returnArrayById($catalogoPuestoM->editByAllPuesto($entity['id_cat_puesto_hraes']));
        $puesto = (!empty($puestoData)) ? $catSelectC->selectByEditCatalogo($catalogoPuestoM->listarByAllPuesto(), $puestoData) : $puesto;
    }

    // ✅ Verificar Puesto Específico
    $puesto_especifico = $catSelectC->selecStaticByNull();
    if (!empty($entity['id_cat_aux_puesto'])) {
        $puestoEspecificoData = $row->returnArrayById($catalogoPuestoM->editSpecificName($entity['id_cat_aux_puesto']));
        $puesto_especifico = (!empty($puestoEspecificoData)) ? $catSelectC->selectByEditCatalogo($catalogoPuestoM->listOfSpecificName($entity['id_cat_puesto_hraes']), $puestoEspecificoData) : $puesto_especifico;
    }

    // ✅ Verificar Unidad de Coordinación
    $unidadCoor = $catSelectC->selectByAllCatalogo($catUnidadAdM->listOfCatCoordinacion());
    if (!empty($entity['id_cat_coordinacion'])) {
        $unidadCoorData = $row->returnArrayById($catUnidadAdM->editOfCatCoordinacion($entity['id_cat_coordinacion']));
        $unidadCoor = (!empty($unidadCoorData)) ? $catSelectC->selectByEditCatalogo($catUnidadAdM->listOfCatCoordinacion(), $unidadCoorData) : $unidadCoor;
    }

    // ✅ Verificar Unidad Administrativa
    $unidadAdmin = $catSelectC->selectByAllCatalogo($catUnidadAdM->lisOfCatUnidad());
    if (!empty($entity['id_cat_unidad'])) {
        $unidadAdminData = $row->returnArrayById($catUnidadAdM->editOfCatUnidad($entity['id_cat_unidad']));
        $unidadAdmin = (!empty($unidadAdminData)) ? $catSelectC->selectByEditCatalogo($catUnidadAdM->lisOfCatUnidad(), $unidadAdminData) : $unidadAdmin;
    }

    // ✅ Verificar Programa
    $programa = $catSelectC->selectByAllCatalogo($contratacionM->listarByAllPrograma());
    if (!empty($entity['id_cat_tipo_programa'])) {
        $programaData = $row->returnArrayById($contratacionM->listarByEditPrograma($entity['id_cat_tipo_programa']));
        $programa = (!empty($programaData)) ? $catSelectC->selectByEditCatalogo($contratacionM->listarByAllPrograma(), $programaData) : $programa;
    }

    // ✅ Verificar Contratación
    $contratacion = $catSelectC->selectByAllCatalogo($contratacionM->Contratacionlist());
    if (!empty($entity['id_cat_tipo_contratacion']) && !empty($entity['id_cat_tipo_trabajador'])) {
        $contratacionData = $row->returnArrayById($contratacionM->listarByEditContratacion($entity['id_cat_tipo_contratacion']));
        $contratacion = (!empty($contratacionData)) ? $catSelectC->selectByEditCatalogo($contratacionM->listarByAllContratacion($entity['id_cat_tipo_trabajador']), $contratacionData) : $contratacion;
    }

    // ✅ Generar JSON con validaciones
    $raw = [
        'entity' => $entity,
        'niveles' => 'NIVEL',
        'zona' => $zona[0] ?? null,
        'plazas' => $plazas,
        'puesto' => $puesto,
        'puesto_especifico' => $puesto_especifico,
        'unidadCoor' => $unidadCoor,
        'unidadAdmin' => $unidadAdmin,
        'programa' => $programa,
        'contratacion' => $contratacion
    ];

    echo json_encode($raw);

} else {
    // ✅ Si no hay ID, mostrar listas completas
    $raw = [
        'entity' => null,
        'niveles' => 'NIVEL',
        'zona' => null,
        'plazas' => $catalogoPlazasC->returnCatPlazas($catalogoPlazasM->listarByAll()),
        'puesto' => $catSelectC->selectByAllCatalogo($catalogoPuestoM->listarByAllPuesto()),
        'puesto_especifico' => $catSelectC->selecStaticByNull(),
        'unidadCoor' => $catSelectC->selectByAllCatalogo($catUnidadAdM->listOfCatCoordinacion()),
        'unidadAdmin' => $catSelectC->selectByAllCatalogo($catUnidadAdM->lisOfCatUnidad()),
        'programa' => $catSelectC->selectByAllCatalogo($contratacionM->listarByAllPrograma()),
        'contratacion' => $catSelectC->selectByAllCatalogo($contratacionM->Contratacionlist())
    ];

    echo json_encode($raw);
}
?>
