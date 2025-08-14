<?php
ini_set('memory_limit', '1024M');
ini_set('display_errors', 0);
ini_set('log_errors', 1);

include '../librerias.php';
require_once '../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

$faltaModelM = new FaltaModelM();

$bool = false;
$message = 'ok';
$inserted = 0;
$incidencias_insertadas = 0;
$debug = [];

$fileExel = 'file';

// 1) Limpiar tabla temporal al inicio
if (!$faltaModelM->truncateTableTmpFaltas()) {
    respond(false, 'Error al truncate table inicial', $inserted, $incidencias_insertadas, $debug);
}

if (!isset($_FILES[$fileExel]) || $_FILES[$fileExel]['error'] !== UPLOAD_ERR_OK) {
    respond(false, 'No se recibió archivo válido.', $inserted, $incidencias_insertadas, $debug);
}

try {
    $archivo = $_FILES[$fileExel]['tmp_name'];
    $spreadsheet = IOFactory::load($archivo);
    /** @var Worksheet $ws */
    $ws = $spreadsheet->getActiveSheet();
    $lastRow = $ws->getHighestDataRow();

    // 2) Leemos SOLO A:E (RFC, FECHA, OBSERVACIONES, TIPO, TIPO_FALTA)
    $data = $ws->rangeToArray('A1:E' . $lastRow, null, true, true, true);

    // Validar que existan columnas A..E en encabezado
    $header = $data[1] ?? [];
    $requeridas = ['A','B','C','D','E'];
    $faltantes = array_diff($requeridas, array_keys($header));
    if (!empty($faltantes)) {
        respond(false, 'Encabezados incompletos: se requieren A..E', $inserted, $incidencias_insertadas, [
            'faltantes' => array_values($faltantes),
            'keys' => array_keys($header),
        ]);
    }

    // 3) Insertar filas (desde la 2)
    for ($r = 2; $r <= $lastRow; $r++) {
        $row = $data[$r] ?? null;
        if (!$row) continue;

        $rfc           = isset($row['A']) ? trim($row['A']) : null;
        $fecha         = isset($row['B']) ? trim($row['B']) : null;
        $observaciones = isset($row['C']) ? trim($row['C']) : null;
        $tipo          = isset($row['D']) ? trim($row['D']) : null;
        $tipo_falta    = isset($row['E']) ? trim($row['E']) : null;

        // Saltar filas totalmente vacías
        if (($rfc === '' || $rfc === null) &&
            ($fecha === '' || $fecha === null) &&
            ($observaciones === '' || $observaciones === null) &&
            ($tipo === '' || $tipo === null) &&
            ($tipo_falta === '' || $tipo_falta === null)) {
            continue;
        }

        $ok = $faltaModelM->addInfoFaltaTemp($rfc, $fecha, $observaciones, $tipo, $tipo_falta);
        if (!$ok) {
            respond(false, 'Error al insertar en tabla temporal en fila ' . $r, $inserted, $incidencias_insertadas, [
                'row' => $row
            ]);
        }
        $inserted++;
    }

    if ($inserted === 0) {
        respond(false, 'El archivo no contiene filas válidas para procesar (A:E).', 0, 0, []);
    }

    // 4) Ejecutar el proceso CTE -> inserta en ctrl_incidencias
    $res = $faltaModelM->updateincidencias(); // tu método ya arma todo el CTE
    if ($res === false) {
        respond(false, 'Error al ejecutar updateincidencias()', $inserted, 0, []);
    }
    $incidencias_insertadas = pg_affected_rows($res);

    // 5) Truncar temporal al final
    if (!$faltaModelM->truncateTableTmpFaltas()) {
        respond(false, 'Se insertó en incidencias, pero falló el truncate final.', $inserted, $incidencias_insertadas, []);
    }

    respond(true, 'ok', $inserted, $incidencias_insertadas, []);

} catch (Throwable $e) {
    respond(false, 'Excepción: ' . $e->getMessage(), $inserted, $incidencias_insertadas, []);
}

function respond($bool, $message, $inserted, $incidencias, $debug = [])
{
    if (ob_get_length()) { ob_clean(); }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'bool' => (bool)$bool,
        'message' => $message,
        'insertados_temp' => (int)$inserted,
        'incidencias_insertadas' => (int)$incidencias,
        'debug' => $debug,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
