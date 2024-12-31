<?php
include '../librerias.php';

$id = $_POST['id_alerta']; // Cambiado a id_alerta
$alertasM = new AlertasM(); // Cambiado a AlertasM
$row = new row();

if ($id != null) {
    $response = $row->returnArrayById($alertasM->getInfoAlerta($id)); // Cambiado a AlertasM y método getInfoAlerta
    $var = [
        'response' => $response,
    ];
    echo json_encode($var);
}
