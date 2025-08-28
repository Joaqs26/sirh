<?php
// Incluir la librería PhpSpreadsheet
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Conexión a la base de datos PostgreSQL
$conexion = pg_connect("host=localhost dbname=sirh user=postgres password=pg2024");
//$conexion = pg_connect("host=localhost dbname=sirh user=postgres password=pg2024");

if (!$conexion) {
    echo "Error: No se pudo conectar a la base de datos.\n";
    exit;
}

// Query SQL para obtener los datos de la tabla
$query = "SELECT * FROM tbl_control_plazas_hraes";
$resultado = pg_query($conexion, $query);

if (!$resultado) {
    echo "Error en la consulta.\n";
    exit;
}

// Crear una nueva instancia de PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar los encabezados de las columnas
$columnas = pg_num_fields($resultado);
for ($i = 0; $i < $columnas; $i++) {
    $sheet->setCellValueByColumnAndRow($i + 1, 1, pg_field_name($resultado, $i));
}

// Iterar sobre los resultados y agregarlos al archivo Excel
$filaActual = 2;
while ($fila = pg_fetch_assoc($resultado)) {
    for ($i = 0; $i < $columnas; $i++) {
        $sheet->setCellValueByColumnAndRow($i + 1, $filaActual, $fila[pg_field_name($resultado, $i)]);
    }
    $filaActual++;
}

// Configurar el nombre del archivo
$filename = 'datos_postgresql.xlsx';

// Crear un objeto Writer para guardar el archivo Excel en la salida directa
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

// Cerrar la conexión a la base de datos
pg_close($conexion);