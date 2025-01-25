<?php
include '../../../../conexion.php';
include '../../../Model/Central/EmpleadosM/EmpleadosM.php';

$listado = new modelEmpleadosHraes();
$paginador = $_POST['paginador'];

$query = $listado->listarByAll($paginador);

if (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) {
    $busqueda = $_POST['busqueda'];
    $query = $listado->listarByLike($busqueda, $paginador);
}

$data = '
    <table class="table table-bordered table-fixed" id="t-table">
        <thead>
            <tr>
                <th class="col-wide-action">Acciones</th>
                <th class="col-wide-x-150">No Plaza</th>
                <th class="col-wide">Zona Pagadora</th>
                <th class="col-wide">R.F.C</th>
                <th class="col-wide">CURP</th>
                <th class="col-wide">Nombre</th>
                <th class="col-wide">Primer Apellido</th>
                <th class="col-wide">Segundo Apellido</th>
                <th class="col-wide">Movimiento</th>
                <th class="col-wide-x-300">CLUES</th>
                <th class="col-wide">Cuenta Clabe</th>
                <th class="col-wide">No Empleado</th>
            </tr>
        </thead>
        <tbody>';

if (!$result = pg_query($connectionDBsPro, $query)) {
    exit(pg_last_error($connectionDBsPro));
}

if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $data .= '
            <tr>
                <td class="col-wide-action">
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-edit icono-grande-tabla"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button onclick="agregarEditarDetalles(' . $row["id_tbl_empleados_hraes"] . ')" class="dropdown-item btn btn-light">
                                <i class="fas fa-edit icon-edit-table"></i> Modificar
                            </button>
                            <form action="../Modulo/index.php" method="POST">
                                <input type="hidden" name="id_tbl_empleados_hraes" value="' . $row["id_tbl_empleados_hraes"] . '" />
                                <button onclick="datosEmpleadosGetDetails(' . $row["id_tbl_empleados_hraes"] . ')" class="dropdown-item btn btn-light">
                                    <i class="fa fa-folder-open icon-edit-table"></i> Datos complem.
                                </button>  
                            </form>
                            <button onclick="eliminarEntity(' . $row["id_tbl_empleados_hraes"] . ')" class="dropdown-item btn btn-light">
                                <i class="far fa-trash-alt icon-delete-table"></i> Eliminar
                            </button>  
                        </div>
                    </div>
                </td>
                <td class="col-wide-x-150">' . ($row["num_plaza"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["zona_pagadora"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["rfc"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["curp"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["nombre"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["primer_apellido"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["segundo_apellido"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["codigo_mov"] . " - " . $row["nombre_movimiento"] ?? '-') . '</td>
                <td class="col-wide-x-300">' . ($row["clave_centro_trabajo"] . " - " . $row["nombre_centro"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["clabe"] ?? '-') . '</td>
                <td class="col-wide">' . ($row["num_empleado"] ?? '-') . '</td>
            </tr>';
    }
} else {
    $data .= '<tr><td colspan="12" class="text-center"><h6>Sin resultados</h6></td></tr>';
}

$data .= '</tbody></table>';

echo $data;
?>
