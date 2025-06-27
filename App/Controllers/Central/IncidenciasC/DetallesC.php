<?php
include '../librerias.php';

$id_object = $_POST['id_object'];
$incidenciasM = new IncidenciasM();
$row = new row();
$catSelectC = new CatSelectC();

if ($id_object != null) {
    $response = $row->returnArray($incidenciasM->modificarIncidencia($id_object));

    // ✅ Devolver todos los elementos y seleccionamos en JS
    $catIncidencias = $catSelectC->selectByAllCatalogo($incidenciasM->listarCatIncidencias());

    $var = [
        'response' => [
            'fecha_inicio' => $response['fecha_inicio'],
            'fecha_fin' => $response['fecha_fin'],
            'fecha_captura' => $response['fecha_captura'],
            'hora' => $response['hora'],
            'observaciones' => $response['observaciones'],
            'id_cat_incidencias' => $response['id_cat_incidencias'],
            'id_tbl_empleados_hraes' => $response['id_tbl_empleados_hraes'],
            'id_user' => $response['id_user'],
            'es_mas_de_un_dia' => $response['es_mas_de_un_dia'],
            'num_oficio' => $response['num_oficio'],
        ],
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
