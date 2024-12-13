<?php

include '../librerias.php';

$catDiasM = new CatDiasM();
$row = new row();

$fechaInicio = $_POST['fecha_inicio_ins'];
$fechaFin = $_POST['fecha_fin_ins'];
$idEmpleado = $_POST['id_tbl_empleados_hraes'];

$fechaInicio_date = new DateTime($fechaInicio);
$fechaFin_date = new DateTime($fechaFin);

$periodo = 'SIN RESULTADO';
$diasSeleccionados = 'SIN RESULTADO';
$diasRestantes = 'SIN RESULTADO';

//Se obtiene el periodo
if ($fechaInicio != '') {
    if (pg_num_rows($catDiasM->getPeriodo($fechaInicio)) > 0) {
        $periodoResult = $row->returnArrayById($catDiasM->getPeriodo($fechaInicio));
        $periodo = $periodoResult[0];
        // calculo de dias seleccionados
        $allDays = getAllDays($periodoResult[1], $periodoResult[2], $idEmpleado);

        if ($fechaInicio != '' && $fechaFin == '') {//funion de un solo dia
            $diasSeleccionados = '1 Día'; //uno perteneciendo a solo un dia que se selecciono
            $diasRestantes = ($allDays - 1) . ' de 15 días';
        } else if ($fechaInicio != '' && $fechaFin != '') { //funcion donde se selecciona un rango de fechas
            if ($fechaInicio < $fechaFin) { // validacion que las fechas esten correctas, la de inicio ser menor que la  fecha fin
                $intervalo = $fechaInicio_date->diff($fechaFin_date); //obtener el intervalo para dias
                $diasSeleccionados = $intervalo->days + 1 . ' Días'; // obtener el total de dias
                $diasRestantes = ($allDays - ($intervalo->days + 1)) . ' de 15 días';
                if (($allDays - ($intervalo->days + 1)) < 0 || ($allDays - ($intervalo->days + 1)) > 15) {
                    $diasRestantes = 'SIN DÍAS LIBRES';
                }
            }
        }
    }
}



$var = [
    'periodo' => $periodo,
    'diasSeleccionados' => $diasSeleccionados,
    'diasRestantes' => $diasRestantes,
];
echo json_encode($var);


function getAllDays($fechaInio, $fechaFin, $idEmployee) // la funcion obtiene el total de vacaciones de empleados
{
    $catDiasM = new CatDiasM();
    $row = new row();

    $result_ = $row->returnArrayById($catDiasM->getMoreDaysForP());
    $days = $result_[0];
    if (pg_num_rows($catDiasM->getAllDays($fechaInio, $fechaFin, $idEmployee)) > 0) {
        $result = $row->returnArrayById($catDiasM->getAllDays($fechaInio, $fechaFin, $idEmployee));
        $days = $result_[0] - $result[0];
    }

    return $days;
}