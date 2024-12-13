<?php
include '../librerias.php';

$id_object = $_POST['id_object'];
$lenguaM = new LenguaM();
$catSelectC = new CatSelectC();
$catLenguaM = new CatLenguaM();
$row = new Row();

if ($id_object != null){
    $response = $row->returnArray($lenguaM->listarByIdEdit($id_object));
    $lengua = $catSelectC->selectByEditCatalogo($catLenguaM->listbyAll(),$row->returnArrayById($catLenguaM->listOfId($response['id_cat_lengua'])));
    $var = [
        'lengua' => $lengua,
    ];
    echo json_encode($var);
} else {
    $lengua = $catSelectC->selectByAllCatalogo($catLenguaM->listbyAll());
    $var = [
        'lengua' => $lengua,
    ];
    echo json_encode($var);
}
