<?php

include '../librerias.php';

$model = new modelCentroTrabajoHraes();
$bitacoraM = new BitacoraM();
$tablaCentroTrabajoHraes = 'central.tbl_centro_trabajo_hraes';

$condicion = [
    'id_tbl_centro_trabajo_hraes' => $_POST['id_object']
];

$datos = [
    'clave_centro_trabajo' => $_POST['clave_centro_trabajo'],
    'nombre' => $_POST['nombre'],
    'pais' => $_POST['pais'],
    'colonia' => $_POST['colonia'],
    'codigo_postal' => $_POST['codigo_postal'],
    'num_exterior' => $_POST['num_exterior'],
    'num_interior' => $_POST['num_interior'],
    'latitud' => $_POST['latitud'],
    'longitud' => $_POST['longitud'],
    'id_cat_region' => $_POST['id_cat_region'],
    'id_estatus_centro' => $_POST['id_estatus_centro'],
    'id_cat_entidad' => $_POST['id_cat_entidad'],
    'id_cat_zona_economica' => $_POST['id_cat_zona_economica'],
    'fecha_usuario' => date('Y-m-d H:i:s'),
    'id_user' => $_SESSION['id_user']
];

$var = [
    'datos' => $datos,
    'condicion' => $condicion
];

try {
    // Verificar si la clave ya pertenece al registro que se está editando
    $claveCentro = $_POST['clave_centro_trabajo'];
    $idActual = $_POST['id_object'];

    $query = "SELECT id_tbl_centro_trabajo_hraes 
              FROM $tablaCentroTrabajoHraes 
              WHERE clave_centro_trabajo = '$claveCentro'";
    $result = pg_query($connectionDBsPro, $query);

    if (pg_num_rows($result) > 0) {
        $duplicatedRow = pg_fetch_assoc($result);
        if ($duplicatedRow['id_tbl_centro_trabajo_hraes'] != $idActual) {
            throw new Exception("Error: La clave centro de trabajo '$claveCentro' ya está en uso en otro registro.");
        }
    }

    if ($_POST['id_object'] != null) { // Modificar
        if ($model->editarByArray($connectionDBsPro, $datos, $condicion, $tablaCentroTrabajoHraes)) {
            $dataBitacora = [
                'nombre_tabla' => $tablaCentroTrabajoHraes,
                'accion' => 'MODIFICAR',
                'valores' => json_encode($var),
                'fecha' => date('Y-m-d H:i:s'),
                'id_users' => $_SESSION['id_user']
            ];
            pg_insert($connectionDBsPro, 'central.bitacora_hraes', $dataBitacora);
            echo 'edit';
        }
    } else { // Agregar
        if ($model->agregarByArray($connectionDBsPro, $datos, $tablaCentroTrabajoHraes)) {
            $dataBitacora = [
                'nombre_tabla' => $tablaCentroTrabajoHraes,
                'accion' => 'AGREGAR',
                'valores' => json_encode($var),
                'fecha' => date('Y-m-d H:i:s'),
                'id_users' => $_SESSION['id_user']
            ];
            pg_insert($connectionDBsPro, 'central.bitacora_hraes', $dataBitacora);
            echo 'add';
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
