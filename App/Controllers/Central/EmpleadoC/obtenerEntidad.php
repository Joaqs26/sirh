<?php
// Incluir la conexión y el modelo
include '../librerias.php';
include '../../../Model/Catalogos/CatEntidadM/CatEntidadM.php';

// Verificar si se envió el CURP
if (!isset($_POST['curp']) || empty($_POST['curp'])) {
    echo json_encode(["error" => "No se recibió CURP"]);
    exit;
}

$curp = strtoupper(trim($_POST['curp']));

// Validar que el CURP tenga al menos 13 caracteres
if (strlen($curp) < 13) {
    echo json_encode(["error" => "CURP inválido"]);
    exit;
}

// Extraer los dos caracteres de la entidad
$claveEntidad = substr($curp, 11, 2);

// Instanciar el modelo con la conexión global
$catEntidadM = new ObtenerEntidadM();   
$entidadResult = $catEntidadM->selectByEditv3($claveEntidad);

if ($entidadResult) {
    $entidad = $entidadResult['entidad'];

    // Determinar si pertenece a México
    $pais = "MÉXICO";
    $nacionalidad = "MEXIC  ANA";

    echo json_encode([
        "pais_nacimiento" => $pais,
        "entidad_nacimiento" => $entidad,
        "nacionalidad" => $nacionalidad
    ]);
} else {
    echo json_encode(["error" => "Entidad no encontrada"]);
}
?>
