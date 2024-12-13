<?php
include '../librerias.php';

$id_object = $_POST['id_object'];
$incidenciasM = new IncidenciasM();
$row = new row();
$catSelectC = new CatSelectC();

if ($id_object != null) {
    $response = $row->returnArray($incidenciasM->modificarIncidencia($id_object));

    $catIncidencias = $catSelectC->selectByAllCatalogo($incidenciasM->listarCatIncidencias());
    if ($response['id_cat_incidencias'] != ''){
        $catIncidencias = $catSelectC->selectByEditCatalogo($incidenciasM->listarCatIncidencias(),$row->returnArrayById($incidenciasM->editarCatIncidencias($response['id_cat_incidencias'])));
    }

    $var = [
        'response' => $response,
        'catIncidencias' => $catIncidencias,
        'periodo' => 'Periodo',
        'diasSeleccionados' => 'Días restantes',
        'diasRestantes' => 'Días seleccionados',
    ];
    echo json_encode($var);

} else {
    $response = $incidenciasM->listarByNull();
    $catIncidencias = $catSelectC->selectByAllCatalogo($incidenciasM->listarCatIncidencias());
    $var = [
        'response' => $response,
        'catIncidencias' => $catIncidencias,
        'periodo' => 'Periodo',
        'diasSeleccionados' => 'Días restantes',
        'diasRestantes' => 'Días seleccionados',

    ];
    echo json_encode($var);
}
