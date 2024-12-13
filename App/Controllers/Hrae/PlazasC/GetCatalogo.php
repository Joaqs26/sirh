<?php
include '../librerias.php';
include '../../../Model/Hraes/Catalogos/CatPuestoM/CatPuestoM.php';

$row = new Row();
$catalogoPuestoM = new catalogoPuestoM();
$catSelectC = new CatSelectC();
$categoriaResp = $catSelectC->selecStaticByNull();

$id_cat_aux_puesto = $_POST['id_cat_aux_puesto'];
$id_cat_puesto_hraes = $_POST['id_cat_puesto_hraes'];

if ($id_cat_aux_puesto != null){
    $isReponse = $catSelectC->selectByAllCatalogo($catalogoPuestoM->listOfCategoName($id_cat_puesto_hraes,$id_cat_aux_puesto));
    $categoriaResp = $isReponse;
} 

$var = [
    'categoriaResp' => $categoriaResp
];
echo json_encode($var);
