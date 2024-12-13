<?php
ini_set('memory_limit', '1024M');

include '../librerias.php';
require_once '../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

/// Class
$faltaModelM = new FaltaModelM();

///Messages
$bool = false;
$message = 'ok';

///VALUE
$fileExel = 'file';
$schema = 'public';
$tableName = $schema . '.ctrl_temp_asistencia';


//Actions
//Truncate table
$bool = $faltaModelM->truncateTableTmpFaltas() ? true : false;
$message = $bool ? 'ok' : 'Error al truncate table';

if (isset($_FILES[$fileExel]) && $_FILES[$fileExel]['error'] === UPLOAD_ERR_OK) { ///VALIDACION DE ARCHIVO
    $archivo = $_FILES[$fileExel]['tmp_name']; ///ARCHIVO TEMPORAL

    $spreadsheet = IOFactory::load($archivo); ///MANIPULACION DE ARCHIVO
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    $numero_columnas = count($sheetData[1]); ///NUMERO DE COLUMNAS DEL ARCHIVO
    $totalFilas = 1; ///NUMERO TOTAL DE FILAS DE REGISTROS

    if ($numero_columnas == 5) {///VALIDAR EL NUMERO DE EL NUMERO DE COLUMNAS COINCIDA
        foreach ($sheetData as $row) {
            if ($totalFilas != 1) {///VALIDACION PARA NO EJECUTAR ENCABEZADO Y TEXTO
                $rfc = trim(pg_escape_string($row['A'])) ? trim(pg_escape_string($row['A'])) : null;//
                $fecha = trim(pg_escape_string($row['B'])) ? trim(pg_escape_string($row['B'])) : null;//
                $observaciones = trim(pg_escape_string($row['C'])) ? trim(pg_escape_string($row['C'])) : null;//
                $tipo = trim(pg_escape_string($row['D'])) ? trim(pg_escape_string($row['D'])) : null;//
                $tipo_falta = trim(pg_escape_string($row['E'])) ? trim(pg_escape_string($row['E'])) : null;//

                $bool = $faltaModelM->addInfoFaltaTemp(
                    $rfc,
                    $fecha,
                    $observaciones,
                    $tipo,
                    $tipo_falta,
                ) ? true : false;

                $message = $bool ? 'ok' : 'Error al insertar en tabla temporal -> volver a intentar';
            }
            $totalFilas++;
        }

        if ($bool) {
            $result = $faltaModelM->udpdateFaltas();
            $bool = $result ? true : false;
            $message = $result ? 'ok' : 'Error de actualizacion de faltas/incidencias -> volver a intentar';
        }

    } else {
        $bool = false;
        $message = 'Las columnas del archivo cargado no corresponden con las columnas del formato requerido.';
    }
}


$var = [
    'bool' => $bool,
    'message' => $message,
];
echo json_encode($var);
