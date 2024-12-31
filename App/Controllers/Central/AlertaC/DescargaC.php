<?php
include '../librerias.php';
require_once '../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

header('Content-Type: text/html; charset=UTF-8');

$alertasM = new AlertasM();
$spreadsheet = new Spreadsheet();

$result = $alertasM->getReporte(); // Obtener datos para el reporte

$sheet = $spreadsheet->getActiveSheet();

// Función para aplicar formato a los encabezados
function formatHeaderCell($sheet, $cell, $value) {
    $sheet->getStyle($cell)->getFont()->setBold(true);
    $sheet->getStyle($cell)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
    $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('12501A'); // Verde brillante
    $sheet->setCellValue($cell, $value);
}

// Encabezados de columna con formato
formatHeaderCell($sheet, 'A1', 'RFC');
formatHeaderCell($sheet, 'B1', 'NOMBRE COMPLETO');
formatHeaderCell($sheet, 'C1', 'TOTAL FALTAS');
formatHeaderCell($sheet, 'D1', 'DÍAS FALTAS');

$row = 2;

// Iterar sobre los resultados de la consulta y escribir en el libro
while ($row_data = pg_fetch_array($result)) {
    $sheet->setCellValue('A' . $row, $row_data['rfc']);
    $sheet->setCellValue('B' . $row, $row_data['nombre_completo']);
    $sheet->setCellValue('C' . $row, $row_data['total_faltas']);
    $sheet->setCellValue('D' . $row, $row_data['dias_faltas']);
    $row++;
}

// Configurar el nombre del archivo para descarga
$filename = 'REPORTE_ALERTAS.xlsx';

// Crear el writer para el archivo Excel y guardarlo en la salida
$writer = new Xlsx($spreadsheet);

// Definir las cabeceras para descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
