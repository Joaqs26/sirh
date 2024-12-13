<?php
include '../librerias.php';

$id_object = $_POST['id_object'];
$modelEspecialidadM = new ModelEspecialidadM();
$catEspecialidadM = new catEspecialidadM();
$catEspecialidadC = new CatEspecialidadC();
$row = new Row();

if ($id_object != null){
    $response = $row->returnArray($modelEspecialidadM->listarByIdEdit($id_object));
    $especialidad = $catEspecialidadC->selectByIdObject($catEspecialidadM->listarByAll(),$row->returnArrayById($catEspecialidadM->obtenerElemetoById($response['id_cat_especialidad_hraes'])));
    $var = [
        'response' => $response,
        'especialidad' => $especialidad,
    ];
    echo json_encode($var);
} else {
    $especialidad = $catEspecialidadC->selectByAll($catEspecialidadM->listarByAll());
    $var = [
        'response' => '',
        'especialidad' => $especialidad,
    ];
    echo json_encode($var);
}
