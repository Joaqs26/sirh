<?php
header('Content-Type: application/json; charset=UTF-8');


require_once dirname(__FILE__, 5) . '/conexion.php';


require_once dirname(__FILE__, 4) . '/Model/Central/FaltaM/FaltaM.php';

try {
    $idFalta    = isset($_POST['id_falta'])    ? (int)$_POST['id_falta']    : 0;
    $idEmpleado = isset($_POST['id_empleado']) ? (int)$_POST['id_empleado'] : 0;

    if ($idEmpleado <= 0 && $idFalta <= 0) {
        echo json_encode(['ok' => false, 'msg' => 'Falta id_empleado o id_falta']);
        exit;
    }

    $model = new FaltaModelM();

    // Si solo llega id_falta, resolver id_empleado con el modelo
    if ($idEmpleado <= 0) {
        $resEmp = $model->idemail($idFalta); 
        if (!$resEmp || pg_num_rows($resEmp) === 0) {
            echo json_encode(['ok' => false, 'msg' => 'Falta no encontrada']);
            exit;
        }
        $rowEmp     = pg_fetch_row($resEmp);
        $idEmpleado = (int)$rowEmp[0];
    }

    // Traer faltas del empleado
    $res = $model->showemail($idEmpleado); 
    if ($res === false) {
        echo json_encode(['ok' => false, 'msg' => 'Error en consulta']);
        exit;
    }

    $faltas = [];
    while ($row = pg_fetch_assoc($res)) {
        $faltas[] = [
            'puesto'  => $row['puesto']  ?? '',
            'nombre'  => $row['nombre']  ?? '',
            'fecha'   => $row['fecha']   ?? null,
            'hora'    => $row['hora']    ?? null,
            'estatus' => $row['estatus'] ?? ''
        ];
    }

    echo json_encode(['ok' => true, 'faltas' => $faltas]);

} catch (Throwable $e) {
    echo json_encode(['ok' => false, 'msg' => 'Excepción: ' . $e->getMessage()]);
}
