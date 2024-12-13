<?php
include '../../../../conexion.php';
include '../../../Model/Hraes/CentroTrabajoM/CentroTrabajoM.php';

$model = new modelCentroTrabajoHraes();

$id_tbl_centro_trabajo_hraes = $_POST['id_tbl_centro_trabajo_hraes'];

$response = returnArrayById($model->infoCentroByPlaza($id_tbl_centro_trabajo_hraes));
$allPlazas = returnArrayById($model->allCountPlazas($id_tbl_centro_trabajo_hraes));

$var = [
    'nombre' => $response[0],
    'clave' => $response[1],
    'codigo_postal' => $response[2],
    'colonia' => $response[3],
    'region' => $response[4],
    'entidad' => $response[5],
    'pais' => $response[6],
    'plazas' => $allPlazas[0]
];
echo json_encode($var);


function returnArrayById($result)
{
    if (pg_num_rows($result) > 0) {
        while ($row = pg_fetch_row($result)) {
            $response = $row;
        }
    }
    return $response;
}
