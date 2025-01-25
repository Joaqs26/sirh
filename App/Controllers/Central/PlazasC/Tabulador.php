<?php
include '../../../../conexion.php';
include '../../../../App/Model/Central/PlazasM/PlazasM.php';

if (!isset($_POST['id'])) {
    echo json_encode(['error' => 'ID no recibido.']);
    exit;
}

$id = $_POST['id'];
$Tabulador = new modelPlazasHraes();
$result = $Tabulador->Tabulador($id);

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta SQL.']);
    exit;
}

// Convertir el resultado de PostgreSQL en un array asociativo
$response = pg_fetch_assoc($result);

if (!$response) {
    echo json_encode(['error' => 'No se encontraron datos para este ID.']);
} else {
    echo json_encode($response);
}
?>


