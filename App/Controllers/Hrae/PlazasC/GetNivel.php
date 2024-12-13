<?php
include '../librerias.php';
include '../../../Model/Hraes/Catalogos/CatPuestoM/CatPuestoM.php';

$row = new Row();
$catalogoPuestoM = new catalogoPuestoM();
$catSelectC = new CatSelectC();
$message = 'NIVEL';
$puestoEsp = $catSelectC->selecStaticByNull();
$categoriaPuesto = $catSelectC->selecStaticByNull();

$id_cat_puesto_hraes = $_POST['id_cat_puesto_hraes'];

if ($id_cat_puesto_hraes != null){
    $isResult = $row ->returnArrayById($catalogoPuestoM->nameOfPuesto($id_cat_puesto_hraes));
    $isResultEsp = $catSelectC->selectByAllCatalogo($catalogoPuestoM->listOfSpecificName($id_cat_puesto_hraes));

    $message = $isResult[0];
    $puestoEsp = $isResultEsp;
} 

$var = [
    'message' => $message,
    'puestoEsp' => $puestoEsp,
    'categoriaPuesto' => $categoriaPuesto,
];
echo json_encode($var);
