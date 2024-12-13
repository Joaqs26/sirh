<?php
include '../librerias.php';

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];

$asistenciaM = new AsistenciaM();
$row = new Row();
$catSelectC = new CatSelectC();
$catAsistenciaM = new CatAsistenciaM();

///variables auxiliares
$id_cat_asistencia_estatus_info = null;
$observaciones_ass = null;
$no_dispositivo_ass = null;
$fecha_inicio_ass = null;
$fecha_fin_ass = null;
$id_cat_asistencia_ubicacion = $catSelectC->selectByAllCatalogo($catAsistenciaM->listOfUbicacion());
$id_cat_asistencia_estatus = $catSelectC->selectByAllCatalogo($catAsistenciaM->listOfEstatus());
$id_cat_jornada_turno = $catSelectC->selectByAllCatalogo($catAsistenciaM->listOfJornadaTurno());
$id_cat_jornada_dias = $catSelectC->selectByAllCatalogo($catAsistenciaM->listOfJornadaDias());
$id_cat_jornada_horario = $catSelectC->selectByAllCatalogo($catAsistenciaM->listOfJornadaHora());
$id_ctrl_jornada = null;
$id_ctrl_asistencia_info = null;

if (pg_num_rows($asistenciaM->editJornadaInfo($id_tbl_empleados_hraes)) > 0) {
    $entity = $row->returnArray($asistenciaM->editJornadaInfo($id_tbl_empleados_hraes));
    $id_ctrl_jornada = ['$id_ctrl_jornada '];

    if($entity['id_cat_jornada_turno'] != ''){
        $id_cat_jornada_turno = $catSelectC->selectByEditCatalogo($catAsistenciaM->listOfJornadaTurno(),$row->returnArrayById($catAsistenciaM->editOfJornadaTurno($entity['id_cat_jornada_turno'])));
    }

    if($entity['id_cat_jornada_dias'] != ''){
        $id_cat_jornada_dias = $catSelectC->selectByEditCatalogo($catAsistenciaM->listOfJornadaDias(),$row->returnArrayById($catAsistenciaM->editOfJornadaDias($entity['id_cat_jornada_dias'])));
    }

    if($entity['id_cat_jornada_horario'] != ''){
        $id_cat_jornada_horario = $catSelectC->selectByEditCatalogo($catAsistenciaM->listOfJornadaHora(),$row->returnArrayById($catAsistenciaM->editOfJornadaHora($entity['id_cat_jornada_horario'])));
    }
}

if (pg_num_rows($asistenciaM->editAsistenciaInfo($id_tbl_empleados_hraes)) > 0) {
    $entity = $row->returnArray($asistenciaM->editAsistenciaInfo($id_tbl_empleados_hraes));
    $observaciones_ass = $entity['observaciones'];
    $no_dispositivo_ass = $entity['no_dispositivo'];
    $fecha_inicio_ass = $entity['fecha_inicio'];
    $fecha_fin_ass = $entity['fecha_fin'];
    $id_ctrl_asistencia_info = $entity['id_ctrl_asistencia_info'];

    if($entity['id_cat_asistencia_ubicacion'] != ''){
        $id_cat_asistencia_ubicacion = $catSelectC->selectByEditCatalogo($catAsistenciaM->listOfUbicacion(),$row->returnArrayById($catAsistenciaM->editOfUbicacion($entity['id_cat_asistencia_ubicacion'])));
    }

    if($entity['id_cat_asistencia_estatus'] != ''){
        $id_cat_asistencia_estatus = $catSelectC->selectByEditCatalogo($catAsistenciaM->listOfEstatus(),$row->returnArrayById($catAsistenciaM->editOfEstatus($entity['id_cat_asistencia_estatus'])));
        $id_cat_asistencia_estatus_info = $entity['id_cat_asistencia_estatus'];
    }
}


$var = [
    'observaciones_ass' => $observaciones_ass,
    'no_dispositivo_ass' => $no_dispositivo_ass,
    'fecha_inicio_ass' => $fecha_inicio_ass,
    'fecha_fin_ass' => $fecha_fin_ass,
    'id_cat_asistencia_ubicacion' => $id_cat_asistencia_ubicacion,
    'id_cat_asistencia_estatus' => $id_cat_asistencia_estatus,
    'id_cat_jornada_turno' => $id_cat_jornada_turno,
    'id_cat_jornada_dias' => $id_cat_jornada_dias,
    'id_cat_jornada_horario' => $id_cat_jornada_horario,
    'id_ctrl_jornada' => $id_ctrl_jornada,
    'id_ctrl_asistencia_info' => $id_ctrl_asistencia_info,
    'id_cat_asistencia_estatus_info' => $id_cat_asistencia_estatus_info
];
echo json_encode($var);