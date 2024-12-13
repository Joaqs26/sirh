<?php

include '../librerias.php';

$row = new Row();
$modelCentroTrabajoHraes = new modelCentroTrabajoHraes();
$catSepomexM = new CatSepomexM();

$codigo_postal = $_POST['codigo_postal'];
$clave_centro_trabajo = $_POST['clave_centro_trabajo'];
$bool = true;
$message = 'ok';

if (pg_num_rows($modelCentroTrabajoHraes->validateClues($clave_centro_trabajo)) === 0) {
    $bool = false;
    $message = 'La clave de CLUES que intentas agregar no está asociada en nuestro catálogo. Por favor, comunícate con el administrador para obtener más información.';
} else if (pg_num_rows($catSepomexM->getCodigoPostal($codigo_postal)) === 0) {
    $bool = false;
    $message = 'El código postal que intentas ingresar no está registrado en nuestro catálogo. Por favor, solicita a tu administrador que lo actualice.';
}

$var = [
    'bool' => $bool,
    'message' => $message,
];
echo json_encode($var);