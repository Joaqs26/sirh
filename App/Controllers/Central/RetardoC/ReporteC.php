<?php
require_once '../../../../vendor/autoload.php';
require_once '../../../../conexion.php'; // Asegúrate que esta conexión sea correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Limpiar buffers previos
if (ob_get_level()) {
    ob_end_clean();
}
ob_start();

// Validar conexión
if (!$connectionDBsPro) {
    die("Error: No se pudo establecer conexión con la base de datos.");
}

// Capturar fechas
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;

// Construir cláusula WHERE
$whereFechas = '';
if ($fechaInicio && $fechaFin) {
    $whereFechas = "WHERE a.fecha::date BETWEEN '$fechaInicio'::date AND '$fechaFin'::date";
} else {
    die("Debes proporcionar el rango de fechas.");
}

// Nueva consulta: registros de asistencia entre 00:00 y 06:00
$query = "
SELECT 
    a.id_ctrl_asistencia,
    e.rfc,
    CONCAT(e.nombre, ' ', e.primer_apellido, ' ', e.segundo_apellido) AS nombre_completo,
    a.fecha,
    a.hora,
    a.dispositivo,
    a.verificacion,
    a.estado,
    a.evento
FROM central.ctrl_asistencia a
INNER JOIN central.tbl_empleados_hraes e ON e.id_tbl_empleados_hraes = a.id_tbl_empleados_hraes
$whereFechas
AND a.hora::time BETWEEN '00:00:00' AND '06:00:00'
ORDER BY a.fecha, a.hora;
";

// Ejecutar query
$result = pg_query($connectionDBsPro, $query);

if (!$result) {
    die("Error al ejecutar la consulta: " . pg_last_error($connectionDBsPro));
}

// Crear archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados
$encabezados = [
    'A1' => 'ID',
    'B1' => 'RFC',
    'C1' => 'NOMBRE COMPLETO',
    'D1' => 'FECHA',
    'E1' => 'HORA',
   // 'F1' => 'DISPOSITIVO',
   // 'G1' => 'VERIFICACIÓN',
   // 'H1' => 'ESTADO',
   //    'I1' => 'EVENTO',
];

// Aplicar encabezados
foreach ($encabezados as $celda => $titulo) {
    $sheet->setCellValue($celda, $titulo);
}

// Estilos para encabezados
$sheet->getStyle('A1:E1')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '12501A']],
]);

// Llenar datos
$fila = 2;
while ($row = pg_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $fila, $row['id_ctrl_asistencia']);
    $sheet->setCellValue('B' . $fila, strtoupper($row['rfc']));
    $sheet->setCellValue('C' . $fila, strtoupper($row['nombre_completo']));
    $sheet->setCellValue('D' . $fila, $row['fecha']);
    $sheet->setCellValue('E' . $fila, $row['hora']);
  //  $sheet->setCellValue('F' . $fila, $row['dispositivo']);
  //  $sheet->setCellValue('G' . $fila, $row['verificacion']);
  //  $sheet->setCellValue('H' . $fila, $row['estado']);
 //   $sheet->setCellValue('I' . $fila, $row['evento']);
    $fila++;
}

// Limpiar buffer
ob_end_clean();

// Descargar Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="REPORTE_MADRUGADA.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
