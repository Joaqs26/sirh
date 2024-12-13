<?php
include '../librerias.php';

$id_object = $_POST['id_object'];
$catEstudioC = new CatEstudioC();
$catEstudioM = new CatEstudioM();
$modelEstudioM = new ModelEstudioM();
$catCarrerasHraesC = new CatCarrerasHraesC();
$catCarrerasHraesM = new CatCarrerasHraesM();
$row = new Row();

if ($id_object != null){
    $response = $row->returnArray($modelEstudioM->listarByIdEdit($id_object));
    $estudio = $catEstudioC ->selectById($catEstudioM->listarByAll(),$row->returnArrayById($catEstudioM->listarElemetoById($response['id_cat_nivel_estudios'])));
    $carrera = $catCarrerasHraesC->selectAll($catCarrerasHraesM ->listarByAll());
    ///VALIDACION DE INFORMACION EN NULL
    if ($response['id_cat_carrera_hraes'] != ''){
        $carrera = $catCarrerasHraesC->selectByIdObject($catCarrerasHraesM->listarByAll(),$row->returnArrayById($catCarrerasHraesM->obtenerElemetoById($response['id_cat_carrera_hraes'])));
    }
    
    $var = [
        'estudio' => $estudio,
        'carrera' => $carrera,
        'response' => $response,
    ];
    echo json_encode($var);
} else {
    $estudio = $catEstudioC ->selectByAll($catEstudioM->listarByAll());
    $carrera = $catCarrerasHraesC->selectAll($catCarrerasHraesM ->listarByAll());
    $var = [
        'estudio' => $estudio,
        'carrera' => $carrera,
        'response' => '',
    ];
    echo json_encode($var);
}
