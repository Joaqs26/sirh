<?php
include '../librerias.php'; // Conexión a la base de datos
// Verifica que la conexión exista
if (!$connectionDBsPro) {
    echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos."]);
    exit;
}
// Recibe la fecha desde POST
$fecha = $_POST['fecha'] ?? null;
// Valida formato
if (!$fecha || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    echo json_encode(["status" => "error", "message" => "Fecha inválida o no proporcionada."]);
    exit;
}
// Ejecuta eliminación por fecha
$query = "DELETE FROM central.ctrl_asistencia WHERE fecha = $1";
$result = pg_query_params($connectionDBsPro, $query, [$fecha]);
// Respuesta
if ($result) {
    echo json_encode(["status" => "success", "message" => "Registros del día $fecha eliminados correctamente."]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudieron eliminar los registros."]);
}
?>

