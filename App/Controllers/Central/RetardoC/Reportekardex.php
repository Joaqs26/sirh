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
// Construir el WHERE para usarlo dentro del WITH
$whereFechas = '';
if ($fechaInicio && $fechaFin) {
    $whereFechas = "AND generate_series(
        ci.fecha_inicio::date,
        CASE 
            WHEN ci.fecha_fin IS NULL OR ci.fecha_fin::text = '' THEN ci.fecha_inicio::date
            ELSE ci.fecha_fin::date
        END,
        interval '1 day'
    )::date BETWEEN '{$fechaInicio}'::date AND '{$fechaFin}'::date";
}



// Query directamente en el archivo para asegurar ejecución
$query = "WITH fechas_expand AS (
    SELECT
        e.rfc,
        e.curp,
        e.nombre || ' ' || e.primer_apellido || ' ' || COALESCE(e.segundo_apellido, '') AS nombre_completo,
        generate_series(
            GREATEST(ci.fecha_inicio::date, '{$fechaInicio}'::date),
            LEAST(
                CASE 
                    WHEN ci.fecha_fin IS NULL OR ci.fecha_fin::text = '' THEN ci.fecha_inicio::date
                    ELSE ci.fecha_fin::date
                END,
                '{$fechaFin}'::date
            ),
            interval '1 day'
        )::date AS fecha,
        ci.observaciones AS folio
    FROM central.ctrl_incidencias ci
    JOIN central.tbl_empleados_hraes e ON e.id_tbl_empleados_hraes = ci.id_tbl_empleados_hraes
    WHERE ci.fecha_inicio IS NOT NULL
)
SELECT 
    rfc,
    curp,
    nombre_completo,
    STRING_AGG(fecha::text || ' - ' || folio, ', ' ORDER BY fecha) AS fechas_folios,
    COUNT(*) AS total_registros
FROM fechas_expand
GROUP BY rfc, curp, nombre_completo
ORDER BY rfc;";



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
$sheet->setCellValue('B1', 'CURP');
$sheet->setCellValue('C1', 'NOMBRE COMPLETO');
$sheet->setCellValue('D1', 'FECHAS Y FOLIOS');
$sheet->setCellValue('E1', 'TOTAL REGISTROS');



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
while ($data = pg_fetch_assoc($result)) {
    $sheet->setCellValue("A$row", $data['rfc']);
$sheet->setCellValue("B$row", $data['curp']);
$sheet->setCellValue("C$row", $data['nombre_completo']);
$sheet->setCellValue("D$row", $data['fechas_folios']);
$sheet->setCellValue("E$row", $data['total_registros']);
$row++;
}

// **Limpieza del buffer**
ob_end_clean();

// Configurar encabezados HTTP para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="REPORTE_KARDEX.xlsx"');
header('Cache-Control: max-age=0');

// Generar el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
