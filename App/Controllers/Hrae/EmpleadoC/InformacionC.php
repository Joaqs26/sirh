<?php
include '../librerias.php';

//class
$modelMovimientosM = new ModelMovimientosM();
$model = new modelEmpleadosHraes();
$row = new Row();
$modelPlazasHraes = new modelPlazasHraes();
$schema = 'public';

$id_object = $_POST['id_tbl_empleados_hraes'];

$empleado = $row->returnArray($model->listarByIdEdit($id_object));

$nombre = $empleado['nombre'];
$primerA =  $empleado['primer_apellido'] ;
$segundoA = $empleado['segundo_apellido'];
$curp = $empleado['curp'];
$rfc = $empleado['rfc'];
$noEmpleado = $empleado['num_empleado'];
$numPlaza = '_';
$unidadResp = '_';
$codPuesto = '_';
$isNivel = '_';
$nomPuesto = '_';
$isClue = '_';
$zonaPag = '_';

$result = $modelMovimientosM->getMaxIdPlaza($schema,$id_object );

if (pg_num_rows($result) > 0) { //consulta con informacion
    $idPlaza = $row->returnArrayById($result);
    $isData = $row->returnArrayById($modelPlazasHraes->getInfoPlaza($schema,$idPlaza[0]));
    //is value
    $numPlaza = $isData[0];
    $unidadResp = $isData[1];
    $codPuesto = $isData[2];
    $isNivel = $isData[3];
    $nomPuesto = $isData[4];
    $isClue = $isData[5];
    $zonaPag = $isData[6];
} 

$var = [
    'nombre' => $nombre,
    'curp' => $curp,
    'rfc' => $rfc,
    'noEmpleado' => $noEmpleado,
    'primerA' => $primerA,
    'segundoA' => $segundoA,
    'numPlaza' => $numPlaza,
    'unidadResp' => $unidadResp,
    'codPuesto' => $codPuesto,
    'isNivel' => $isNivel,
    'nomPuesto' => $nomPuesto,
    'isClue' => $isClue,
    'zonaPag' => $zonaPag,
];

echo json_encode($var);