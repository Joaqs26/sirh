<?php
include '../librerias.php'; // Conexión a la base de datos

// Verifica que la conexión exista
if (!$connectionDBsPro) {
    echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos."]);
    exit;
}

// Ejecuta la consulta para truncar las tres tablas
$query = "
    TRUNCATE TABLE 
        central.ctrl_faltas, 
        central.ctrl_retardo, 
        central.ctrl_asistencia 
    RESTART IDENTITY CASCADE;
";

$result = pg_query($connectionDBsPro, $query);

// Verifica si la consulta fue exitosa
if ($result) {
    echo json_encode(["status" => "success", "message" => "Las tablas han sido truncadas correctamente."]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudieron truncar las tablas."]);
}
?>
    