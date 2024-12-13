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

$insertData = $asistenciaM->addDataInTables();
$result = $asistenciaM->getReporte();

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
formatHeaderCell($sheet, 'B1', 'CURP');
formatHeaderCell($sheet, 'C1', 'NOMBRE');
formatHeaderCell($sheet, 'D1', 'PRIMER APELLIDO');
formatHeaderCell($sheet, 'E1', 'SEGUNDO APELLIDO');
formatHeaderCell($sheet, 'F1', 'FECHA');
formatHeaderCell($sheet, 'G1', 'HORA');
formatHeaderCell($sheet, 'H1', 'TIPO DE ASISTENCIA');
formatHeaderCell($sheet, 'I1', 'DISPOSITIVO');
formatHeaderCell($sheet, 'J1', 'VERIFICACIÓN');
formatHeaderCell($sheet, 'K1', 'ESTADO');
formatHeaderCell($sheet, 'L1', 'EVENTO');
formatHeaderCell($sheet, 'M1', 'ID BIOMÉTRICO');


$row = 2;

// Iterar sobre los resultados de la consulta y escribir en el libro
while ($row_data = pg_fetch_array($result)) {
    $sheet->setCellValue('A' . $row, $row_data[0]);
    $sheet->setCellValue('B' . $row, $row_data[1]);
    $sheet->setCellValue('C' . $row, $row_data[2]);
    $sheet->setCellValue('D' . $row, $row_data[3]);
    $sheet->setCellValue('E' . $row, $row_data[4]);
    $sheet->setCellValue('F' . $row, $row_data[5]);
    $sheet->setCellValue('G' . $row, $row_data[6]);
    $sheet->setCellValue('H' . $row, $row_data[7]);
    $sheet->setCellValue('I' . $row, $row_data[8]);
    $sheet->setCellValue('J' . $row, $row_data[9]);
    $sheet->setCellValue('K' . $row, $row_data[10]);
    $sheet->setCellValue('L' . $row, $row_data[11]);
    $sheet->setCellValue('m' . $row, $row_data[12]);
    $row++;
}

// Configurar el nombre del archivo para descarga
$filename = 'LAYOUT_ASISTENCIAS_RESULTADOS' . '.xlsx';

// Crear el writer para el archivo Excel y guardarlo en la salida
$writer = new Xlsx($spreadsheet);

// Definir las cabeceras para descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;

