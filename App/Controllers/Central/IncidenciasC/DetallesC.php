<?php
include '../librerias.php';

$id_object = $_POST['id_object'];
$incidenciasM = new IncidenciasM();
$row = new row();
$catSelectC = new CatSelectC();
$catDiasM = new CatDiasM(); // Para obtener los periodos

if ($id_object != null) {
    $response = $row->returnArray($incidenciasM->modificarIncidencia($id_object));

    // ✅ Cargar catálogo de incidencias
    $catIncidencias = $catSelectC->selectByAllCatalogo($incidenciasM->listarCatIncidencias());

    // ✅ Obtener todos los periodos
    $periodosResult = $catDiasM->getPeriodos();
    $periodos = pg_fetch_all($periodosResult);

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
            'id_cat_periodo' => $response['id_cat_periodo'], // 👈 importante
        ],
        'catIncidencias' => $catIncidencias,
        'periodos' => $periodos, // 👈 el arreglo de periodos que llenará el select
      /*  'periodo' => 'Periodo',*/
        'diasSeleccionados' => 'Días seleccionados',
        'diasRestantes' => 'Días restantes',
    ];

    echo json_encode($var);

} else {
    $response = $incidenciasM->listarByNull();
    $catIncidencias = $catSelectC->selectByAllCatalogo($incidenciasM->listarCatIncidencias());

    // ✅ Obtener periodos aunque sea nuevo
    $periodosResult = $catDiasM->getPeriodos();
    $periodos = pg_fetch_all($periodosResult);

    $var = [
        'response' => $response,
        'catIncidencias' => $catIncidencias,
        'periodos' => $periodos, // 👈 el arreglo
       /* 'periodo' => 'Periodo',*/
        'diasSeleccionados' => 'Días seleccionados',
        'diasRestantes' => 'Días restantes',
    ];

    echo json_encode($var);
}
