<?php
include '../librerias.php';
require_once '../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

/// Class
$asistenciaM = new AsistenciaM();

///Messages
$bool = false;
$message = 'ok';

///VALUE
$fileExel = 'file';
$schema = 'public';
$tableName = $schema . '.ctrl_temp_asistencia';


//Actions
//Truncate table
$bool = $asistenciaM->truncateTable($tableName) ? true : false;
$message = $bool ? 'ok' : 'Error al truncate table';

if (isset($_FILES[$fileExel]) && $_FILES[$fileExel]['error'] === UPLOAD_ERR_OK) { ///VALIDACION DE ARCHIVO
    $archivo = $_FILES[$fileExel]['tmp_name']; ///ARCHIVO TEMPORAL

    $spreadsheet = IOFactory::load($archivo); ///MANIPULACION DE ARCHIVO
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    $numero_columnas = count($sheetData[1]); ///NUMERO DE COLUMNAS DEL ARCHIVO
    $totalFilas = 1; ///NUMERO TOTAL DE FILAS DE REGISTROS

    if ($numero_columnas == 11) {///VALIDAR EL NUMERO DE EL NUMERO DE COLUMNAS COINCIDA
        foreach ($sheetData as $row) {
            if ($totalFilas != 1) {///VALIDACION PARA NO EJECUTAR ENCABEZADO Y TEXTO
                $tiempo = trim(pg_escape_string($row['A'])) ? trim(pg_escape_string($row['A'])) : null;//
                $id_usuario = trim(pg_escape_string($row['B'])) ? trim(pg_escape_string($row['B'])) : null;//
                $nombre = trim(pg_escape_string($row['C'])) ? trim(pg_escape_string($row['C'])) : null;//
                $apellido = trim(pg_escape_string($row['D'])) ? trim(pg_escape_string($row['D'])) : null;//
                $num_tarjeta = trim(pg_escape_string($row['E'])) ? trim(pg_escape_string($row['E'])) : null;//
                $dispositivo = trim(pg_escape_string($row['F'])) ? trim(pg_escape_string($row['F'])) : null;//
                $punto_evento = trim(pg_escape_string($row['G'])) ? trim(pg_escape_string($row['G'])) : null;//
                $verificacion = trim(pg_escape_string($row['H'])) ? trim(pg_escape_string($row['H'])) : null;//
                $estado = trim(pg_escape_string($row['I'])) ? trim(pg_escape_string($row['I'])) : null;//
                $evento = trim(pg_escape_string($row['J'])) ? trim(pg_escape_string($row['J'])) : null;//
                $notas = trim(pg_escape_string($row['K'])) ? trim(pg_escape_string($row['K'])) : null;//

                $bool = $asistenciaM->addInfoAsistenciaTemp(
                    $tableName,
                    $tiempo,
                    $id_usuario,
                    $nombre,
                    $apellido,
                    $num_tarjeta,
                    $dispositivo,
                    $punto_evento,
                    $verificacion,
                    $estado,
                    $evento,
                    $notas,
                ) ? true : false;

                $message = $bool ? 'ok' : 'Error al insertar en tabla temporal';
            }
            $totalFilas++;
        }

        /*
        $bool = $masivoFaltasM->validateDateFaltas($tableName, 'fecha_desde', 'FECHA INICIO') ? true : false;
        $bool = $masivoFaltasM->validateDateFaltas($tableName, 'fecha_hasta', 'FECHA FIN') ? true : false;
        $bool = $masivoFaltasM->validateDateFaltas($tableName, 'fecha_registro', 'FECHA REGISTRO') ? true : false;
        $bool = $masivoFaltasM->validateMaxFaltas($tableName, 'codigo_certificacion', 'CODIGO CERTIFIACION', 10) ? true : false;
        $bool = $masivoFaltasM->validateMaxFaltas($tableName, 'observaciones', 'OBSERVACIONES', 50) ? true : false;
        $bool = $masivoFaltasM->validateEmployeCurp($tableName) ? true : false;
        $bool = $masivoFaltasM->updateEstatus($tableName) ? true : false;
        $bool = $masivoFaltasM->insertFaltasInCtrl($tableNameNovel, $tableName, $tableNameEmployee) ? true : false;
        $message = $bool ? 'ok' : 'Error al insertar en tabla temporal';
        */

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

/*
/// Class
$masivoFaltasM = new MasivoFaltasM();

///Messages
$bool = false;
$message = 'ok';

///VALUE
$tableName = 'public.masivo_ctrl_faltas_hraes';
$tableNameNovel = 'public.ctrl_faltas_hraes';
$tableNameEmployee = 'public.tbl_empleados_hraes';
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
*/