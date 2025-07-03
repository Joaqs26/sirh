<?php
include '../librerias.php';

$catDiasM = new CatDiasM();
$row = new row();

$idPeriodo = $_POST['id_periodo'];
$idEmpleado = $_POST['id_tbl_empleados_hraes'];

$periodo = 'SIN RESULTADO';
$diasSeleccionados = 'SIN RESULTADO';
$diasRestantes = 'SIN RESULTADO';

if ($idPeriodo != '') {
    // 1) Consultar la descripción del periodo
    $queryPeriodo = pg_query("SELECT descripcion FROM central.cat_periodo WHERE id_cat_periodo = $idPeriodo");
    if ($resPeriodo = pg_fetch_assoc($queryPeriodo)) {
        $periodo = $resPeriodo['descripcion'];
    }

    // 2) Sumar todos los días del empleado que correspondan a este periodo (sin filtrar por fechas)
    $queryDias = pg_query("SELECT
            SUM(
                CASE
                    WHEN ci.fecha_fin IS NOT NULL THEN
                        (ci.fecha_fin - ci.fecha_inicio)::int + 1
                    ELSE
                        1
                END
            ) AS total_dias
        FROM
            central.ctrl_incidencias ci
        WHERE
            ci.id_tbl_empleados_hraes = $idEmpleado
            AND ci.id_cat_incidencias IN (7,14,15)
            AND ci.id_cat_periodo = $idPeriodo
    ");

    $diasTomados = 0;
    if ($resDias = pg_fetch_assoc($queryDias)) {
        $diasTomados = intval($resDias['total_dias']);
    }

    $diasSeleccionados = "$diasTomados Días";
    $diasRestantes = (10 - $diasTomados) . " de 10 días";
}

$var = [
    'periodo' => $periodo,
    'diasSeleccionados' => $diasSeleccionados,
    'diasRestantes' => $diasRestantes,
];

echo json_encode($var);
?>
