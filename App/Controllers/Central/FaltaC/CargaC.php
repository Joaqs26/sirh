<?php
include '../librerias.php';
require_once '../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

/// Class
$masivoFaltasM = new MasivoFaltasM();

///Messages
$bool = false;
$message = 'ok';

///VALUE
$tableName = 'central.masivo_ctrl_faltas_hraes';
$tableNameNovel = 'central.ctrl_faltas';
$tableNameEmployee = 'central.tbl_empleados_hraes';
$fileExel = 'file';

//Actions
//Truncate table
$bool = $masivoFaltasM->truncateTable($tableName) ? true : false;
$message = $bool ? 'ok' : 'Error al truncate table';

if (isset($_FILES[$fileExel]) && $_FILES[$fileExel]['error'] === UPLOAD_ERR_OK) { ///VALIDACION DE ARCHIVO
    $archivo = $_FILES[$fileExel]['tmp_name']; ///ARCHIVO TEMPORAL

    $spreadsheet = IOFactory::load($archivo); ///MANIPULACION DE ARCHIVO
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    $numero_columnas = count($sheetData[1]); ///NUMERO DE COLUMNAS DEL ARCHIVO
    $totalFilas = 1; ///NUMERO TOTAL DE FILAS DE REGISTROS

    if ($numero_columnas == 6) {///VALIDAR EL NUMERO DE EL NUMERO DE COLUMNAS COINCIDA
        foreach ($sheetData as $row) {
            if ($totalFilas != 1) {///VALIDACION PARA NO EJECUTAR ENCABEZADO Y TEXTO
                $curp = trim(pg_escape_string($row['A'])) ? trim(pg_escape_string($row['A'])) : null;//CLAVE DE CENTRO DE TRABAJO
                $fecha_desde = trim(pg_escape_string($row['B'])) ? trim(pg_escape_string($row['B'])) : null;//NOMBRE
                $fecha_hasta = trim(pg_escape_string($row['C'])) ? trim(pg_escape_string($row['C'])) : null;//PAIS
                $fecha_registro = trim(pg_escape_string($row['D'])) ? trim(pg_escape_string($row['D'])) : null;//PAIS
                $codigo_certificacion = trim(pg_escape_string($row['E'])) ? trim(pg_escape_string($row['E'])) : null;//PAIS
                $observaciones = trim(pg_escape_string($row['F'])) ? trim(pg_escape_string($row['F'])) : null;//PAIS

                $bool = $masivoFaltasM->insertFaltas($tableName, $fecha_desde, $fecha_hasta, $fecha_registro, $codigo_certificacion, $curp, $observaciones) ? true : false;

                $message = $bool ? 'ok' : 'Error al insertar en tabla temporal';
            }
            $totalFilas++;
        }

        $bool = $masivoFaltasM->validateDateFaltas($tableName, 'fecha_desde', 'FECHA INICIO') ? true : false;
        $bool = $masivoFaltasM->validateDateFaltas($tableName, 'fecha_hasta', 'FECHA FIN') ? true : false;
        $bool = $masivoFaltasM->validateDateFaltas($tableName, 'fecha_registro', 'FECHA REGISTRO') ? true : false;
        $bool = $masivoFaltasM->validateMaxFaltas($tableName, 'codigo_certificacion', 'CODIGO CERTIFIACION', 10) ? true : false;
        $bool = $masivoFaltasM->validateMaxFaltas($tableName, 'observaciones', 'OBSERVACIONES', 50) ? true : false;
        $bool = $masivoFaltasM->validateEmployeCurp($tableName) ? true : false;
        $bool = $masivoFaltasM->updateEstatus($tableName) ? true : false;
        $bool = $masivoFaltasM->insertFaltasInCtrl($tableNameNovel, $tableName, $tableNameEmployee) ? true : false;
        $message = $bool ? 'ok' : 'Error al insertar en tabla temporal';

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
