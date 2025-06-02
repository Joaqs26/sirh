<?php
require_once '../../../../vendor/autoload.php';
require_once '../../../../App/Model/Central/RetardoM/RetardoM.php';
require_once '../../../../conexion.php'; // Incluir conexión a la base de datos

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// **Evitar cualquier salida previa**
if (ob_get_level()) {
    ob_end_clean();
}
ob_start();

// Crear la conexión manualmente para depurar
if (!$connectionDBsPro) {
    die("Error: No se pudo establecer conexión con la base de datos.");
}

// Capturar las fechas enviadas por POST
$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;

// Construir el WHERE dinámicamente si hay rango de fechas
$whereFechas = '';
if ($fechaInicio && $fechaFin) {
   $whereFechas = "WHERE ctrl_retardo.fecha::DATE BETWEEN '$fechaInicio'::DATE AND '$fechaFin'::DATE";
}

// Query directamente en el archivo para asegurar ejecución
$query = "
SELECT
    CONCAT(UPPER(tbl_empleados_hraes.nombre), ' ',
           UPPER(tbl_empleados_hraes.primer_apellido), ' ',
           UPPER(tbl_empleados_hraes.segundo_apellido)) AS nombre_completo,
    UPPER(tbl_empleados_hraes.rfc) AS rfc,
    TO_CHAR(ctrl_retardo.fecha, 'DD-MM-YYYY') AS fecha,
    TO_CHAR(ctrl_retardo.hora, 'HH24:MI') AS hora,
    UPPER(ctrl_retardo.observaciones) AS observaciones,
    UPPER(cat_retardo_tipo.descripcion) AS tipo_descripcion,
    UPPER(cat_retardo_estatus.descripcion) AS estatus_descripcion,
    ctrl_retardo.id_user AS id_user
FROM central.ctrl_retardo
INNER JOIN central.cat_retardo_tipo
    ON ctrl_retardo.id_cat_retardo_tipo = cat_retardo_tipo.id_cat_retardo_tipo
INNER JOIN central.cat_retardo_estatus
    ON ctrl_retardo.id_cat_retardo_estatus = cat_retardo_estatus.id_cat_retardo_estatus
INNER JOIN central.tbl_empleados_hraes
    ON ctrl_retardo.id_tbl_empleados_hraes = tbl_empleados_hraes.id_tbl_empleados_hraes
INNER JOIN central.ctrl_asistencia_info cai
    ON tbl_empleados_hraes.id_tbl_empleados_hraes = cai.id_tbl_empleados_hraes
$whereFechas
ORDER BY ctrl_retardo.fecha DESC;";

// Ejecutar el query directamente
$result = pg_query($connectionDBsPro, $query);

// Validar el resultado del query
if (!$result) {
    die("Error al ejecutar la consulta: " . pg_last_error($connectionDBsPro));
}

// Crear el archivo Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar encabezados de columna
$sheet->setCellValue('A1', 'RFC');
$sheet->setCellValue('B1', 'NOMBRE COMPLETO');
$sheet->setCellValue('C1', 'FECHA');
$sheet->setCellValue('D1', 'HORA');
$sheet->setCellValue('E1', 'TIPO');
$sheet->setCellValue('F1', 'ESTATUS');
$sheet->setCellValue('G1', 'OBSERVACIONES');

// Aplicar estilo a los encabezados
$styleArray = [
    'font' => ['bold' => true],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '12501A'],
    ],
    'font' => ['color' => ['rgb' => 'FFFFFF']],
];
$sheet->getStyle('A1:G1')->applyFromArray($styleArray);

// Llenar datos desde el query
$row = 2;
while ($row_data = pg_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $row_data['rfc']);
    $sheet->setCellValue('B' . $row, $row_data['nombre_completo']);
    $sheet->setCellValue('C' . $row, $row_data['fecha']);
    $sheet->setCellValue('D' . $row, $row_data['hora']);
    $sheet->setCellValue('E' . $row, $row_data['tipo_descripcion']);
    $sheet->setCellValue('F' . $row, $row_data['estatus_descripcion']);
    $sheet->setCellValue('G' . $row, $row_data['observaciones']);
    $row++;
}

// **Limpieza del buffer**
ob_end_clean();

// Configurar encabezados HTTP para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="REPORTE_RETARDOS.xlsx"');
header('Cache-Control: max-age=0');

// Generar el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
