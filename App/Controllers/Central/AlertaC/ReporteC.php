<?php
require_once '../../../../vendor/autoload.php';
require_once '../../../../App/Model/Central/Alerta/AlertasM.php';
require_once '../../../../conexion.php'; // Conexión a la base de datos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// **Evitar cualquier salida previa**
if (ob_get_level()) {
    ob_end_clean();
}
ob_start();

// Crear instancia de la clase `AlertasM` con la conexión
$alertasM = new AlertasM($connectionDBsPro); // Asegúrate de que `$connectionDBsPro` esté definido en `conexion.php`

// Obtener los datos necesarios
$result = $alertasM->listarById('', 0); // Ajusta los parámetros si es necesario
if (!$result) {
    die("Error en la consulta: " . pg_last_error($connectionDBsPro));
}

// Crear el archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar encabezados de columna
$sheet->setCellValue('A1', 'RFC');
$sheet->setCellValue('B1', 'NOMBRE COMPLETO');
$sheet->setCellValue('C1', 'TOTAL FALTAS');
$sheet->setCellValue('D1', 'DIAS FALTAS');

// Aplicar estilo a los encabezados
$styleArray = [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '12501A'],
    ],
    'font' => ['color' => ['rgb' => 'FFFFFF']],
];
$sheet->getStyle('A1:D1')->applyFromArray($styleArray);

// Llenar datos desde el query
$row = 2;
while ($row_data = pg_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $row_data['rfc']);
    $sheet->setCellValue('B' . $row, $row_data['nombre_completo']);
    $sheet->setCellValue('C' . $row, $row_data['total_faltas']);
    $sheet->setCellValue('D' . $row, $row_data['dias_faltas']);
    $row++;
}

// **Limpieza del buffer**
ob_end_clean();

// Configurar encabezados HTTP para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="REPORTE_ALERTAS.xlsx"');
header('Cache-Control: max-age=0');

// Generar el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
