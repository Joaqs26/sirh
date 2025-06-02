<?php
include '../librerias.php';
require_once '../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

header('Content-Type: text/html; charset=UTF-8');

$asistenciaM = new AsistenciaM();
$spreadsheet = new Spreadsheet();

// Captura el rango de fechas del POST
$fechaInicio = $_POST['fecha_inicio'] ?? null;
$fechaFin = $_POST['fecha_fin'] ?? null;

// Validación opcional (puedes eliminarla si no la necesitas)
if ($fechaInicio && $fechaFin) {
    // Ejecutar inserciones o procesos previos si es necesario
    $asistenciaM->isTruncate();
    $asistenciaM->insertFalta();
}

// Consulta los datos filtrados
$result = $asistenciaM->selectFaltas($fechaInicio, $fechaFin);

// Hoja activa
$sheet = $spreadsheet->getActiveSheet();

// Encabezados con formato
function formatHeaderCell($sheet, $cell, $value)
{
    $sheet->getStyle($cell)->getFont()->setBold(true);
    $sheet->getStyle($cell)->getFont()->getColor()->setRGB('FFFFFF');
    $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('12501A');
    $sheet->setCellValue($cell, $value);
}

$headers = ['RFC', 'UNIDAD', 'COORDINACION', 'PUESTO', 'NOMBRE', 'MOVIL', 'NO_DISPOSITIVO', 'FECHA', 'HORA', 'CANTIDAD', 'ESTATUS'];
$col = 'A';
foreach ($headers as $header) {
    formatHeaderCell($sheet, $col . '1', $header);
    $col++;
}

// Escribir datos
$row = 2;
while ($row_data = pg_fetch_array($result)) {
    $col = 'A';
    foreach ($row_data as $i => $value) {
        if (is_int($i)) continue; // Evita columnas duplicadas por índice numérico
        $sheet->setCellValue($col . $row, $value);
        $col++;
    }
    $row++;
}

// Configurar descarga
$filename = 'REPORTE_FALTAS.xlsx';
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
