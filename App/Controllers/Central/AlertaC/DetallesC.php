<?php
include '../librerias.php';

$id_alerta = $_POST['id_alerta']; // Cambiado a id_alerta
$alertasM = new AlertasM(); // Cambiado a AlertasM
$row = new row();

if ($id_alerta != null) {
    $response = $row->returnArray($alertasM->editAlerta($id_alerta)); // Método para editar alertas
    $var = [
        'response' => $response,
    ];
    echo json_encode($var);
} else {
    $response = $alertasM->alertaIsNull(); // Método para manejar alertas nulas
    $var = [
        'response' => $response,
    ];
    echo json_encode($var);
}
