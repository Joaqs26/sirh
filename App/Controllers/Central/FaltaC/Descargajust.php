<?php
// Descargajust.php — Exporta SOLO lo NO insertado desde central.masivo_ctrl_temp_faltas_just

include '../librerias.php';
require '../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

// Parámetro opcional (ya no se usa para truncar)
//$doTruncate = (isset($_GET['truncate']) && $_GET['truncate'] === '1');

// ---- 1) Consulta: qué no se insertó y por qué ----
$sql = "WITH m AS (
  SELECT TRIM(rfc) AS rfc,
         TRIM(observaciones) AS observaciones,
         TRIM(tipo) AS tipo,
         fecha::date AS fecha
  FROM central.masivo_ctrl_temp_faltas_just
),
e AS (
  SELECT rfc, id_tbl_empleados_hraes
  FROM central.tbl_empleados_hraes
),
m2 AS (
  SELECT
    m.*,
    e.id_tbl_empleados_hraes,
    CASE
      WHEN unaccent(m.tipo) ILIKE unaccent('AUTORIZACION DE OMISION DE REGISTRO DE ENTRADA') THEN 1
      WHEN unaccent(m.tipo) ILIKE unaccent('AUTORIZACION DE OMISION DE REGISTRO DE SALIDA')  THEN 2
      WHEN unaccent(m.tipo) ILIKE unaccent('CAPACITACION FUERA DE LAS INSTALACIONES')        THEN 3
      WHEN unaccent(m.tipo) ILIKE unaccent('CONSTANCIA DE TIEMPO ISSSTE')                    THEN 4
      WHEN unaccent(m.tipo) ILIKE unaccent('COMISION OFICIAL')                               THEN 5
      WHEN unaccent(m.tipo) ILIKE unaccent('CUIDADOS MEDICOS')                               THEN 6
      WHEN unaccent(m.tipo) ILIKE unaccent('DIAS A CUENTA DE VACACIONES')                    THEN 7
      WHEN unaccent(m.tipo) ILIKE unaccent('OTRO')                                           THEN 8
      WHEN unaccent(m.tipo) ILIKE unaccent('PASE DE ENTRADA')                                THEN 9
      WHEN unaccent(m.tipo) ILIKE unaccent('PASE DE SALIDA')                                 THEN 10
      WHEN unaccent(m.tipo) ILIKE unaccent('PERMISO POR DEFUNCION DE UN FAMILIAR DIRECTO')   THEN 11
      WHEN unaccent(m.tipo) ILIKE unaccent('RETARDO MAYOR')                                  THEN 12
      WHEN unaccent(m.tipo) ILIKE unaccent('RETARDO MENOR')                                  THEN 13
      WHEN unaccent(m.tipo) ILIKE unaccent('VACACIONES EXTRAORDINARIAS')                     THEN 14
      WHEN unaccent(m.tipo) ILIKE unaccent('VACACIONES ORDINARIAS')                          THEN 15
      WHEN unaccent(m.tipo) ILIKE unaccent('LICENCIA MEDICA')                                THEN 16
      WHEN unaccent(m.tipo) ILIKE unaccent('PERMISO POR PATERNIDAD')                         THEN 17
      WHEN unaccent(m.tipo) ILIKE unaccent('FALTA REGISTRO EN BIOMETRICO')                   THEN 18
      ELSE NULL
    END AS id_cat_incidencias
  FROM m LEFT JOIN e ON e.rfc = m.rfc
),
chk AS (
  SELECT
    m2.*,
    CASE
      WHEN m2.id_tbl_empleados_hraes IS NULL THEN 'RFC_NO_ENCONTRADO'
      WHEN m2.id_cat_incidencias IS NULL THEN 'TIPO_DESCONOCIDO'
      WHEN EXISTS (
        SELECT 1
        FROM central.ctrl_incidencias ci
        WHERE ci.id_tbl_empleados_hraes = m2.id_tbl_empleados_hraes
          AND ci.id_cat_incidencias     = m2.id_cat_incidencias
          AND daterange(ci.fecha_inicio::date, COALESCE(ci.fecha_fin::date, ci.fecha_inicio::date), '[]')
              @> m2.fecha
      ) THEN 'INSERTADA'
      ELSE 'NO_INSERTADA'
    END AS estado
  FROM m2
)
SELECT *
FROM chk
WHERE estado <> 'INSERTADA'
ORDER BY rfc, fecha, tipo;
";

$result = pg_query($connectionDBsPro, $sql);
if ($result === false) {
  http_response_code(500);
  exit('Error en la consulta de verificación.');
}

// ---- 2) (NO truncar) Leer a memoria y continuar ----
$rows = [];
while ($r = pg_fetch_assoc($result)) { $rows[] = $r; }

// *** Antes truncaba aquí. Eliminado para NO borrar la temporal. ***
// if ($doTruncate) {
//   pg_query($connectionDBsPro, "TRUNCATE central.masivo_ctrl_temp_faltas_just");
// }

// ---- 3) Construir XLSX con solo NO insertadas ----
$ss = new Spreadsheet();
$sh = $ss->getActiveSheet();
$sh->setTitle('No Insertadas');

$headers = ['RFC','FECHA','OBSERVACIONES','TIPO','ID_EMPLEADO','ID_CAT_INCIDENCIAS','MOTIVO'];
foreach ($headers as $i => $label) {
  $cell = chr(65+$i).'1';
  $sh->setCellValue($cell, $label);
  $sh->getStyle($cell)->getFont()->setBold(true)->getColor()->setARGB(Color::COLOR_WHITE);
  $sh->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C00000');
}

$rowNum = 2;
foreach ($rows as $r) {
  $sh->setCellValueExplicit('A'.$rowNum, $r['rfc'] ?? '', DataType::TYPE_STRING);
  $sh->setCellValue('B'.$rowNum, $r['fecha'] ?? '');
  $sh->setCellValue('C'.$rowNum, $r['observaciones'] ?? '');
  $sh->setCellValue('D'.$rowNum, $r['tipo'] ?? '');
  $sh->setCellValue('E'.$rowNum, $r['id_tbl_empleados_hraes'] ?? '');
  $sh->setCellValue('F'.$rowNum, $r['id_cat_incidencias'] ?? '');
  $sh->setCellValue('G'.$rowNum, $r['estado'] ?? 'NO_INSERTADA');
  $rowNum++;
}

foreach (['A','B','C','D','E','F','G'] as $col) {
  $sh->getColumnDimension($col)->setAutoSize(true);
}

// ---- 4) Salida limpia y descarga ----
if (ob_get_length()) { ob_end_clean(); }
ini_set('zlib.output_compression', '0');

$filename = 'No_Insertadas_'.date('Ymd_His').'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

$writer = new Xlsx($ss);
$writer->save('php://output');
exit;
