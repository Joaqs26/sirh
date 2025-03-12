<?php
include '../../../../../conexion.php';
include '../../../../Model/Central/MovimientosM/MovimientosM.php';

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];
$paginador = $_POST['paginador'];
$modelMovimientosM = new ModelMovimientosM();
$listado = $modelMovimientosM->listarByIdEmpleado($id_tbl_empleados_hraes, $paginador);

if (isset($_POST['busqueda'])) {
    $listado = $modelMovimientosM->listarByBusqueda($id_tbl_empleados_hraes, $paginador, $_POST['busqueda']);
}

$data =
    '<table class="table table-bordered" id="tabla_movimientos" style="width:100%">
    <thead>
        <tr>
            <th>Acciones</th>
            <th>N&uacutem. Plaza</th>
            <th>Movimiento espec&iacute;fico</th>
            <th>Fecha movimiento</th>
            <th>Fecha inicio</th>
            <th>Fecha t&eacute;rmino</th>
        </tr>
    </thead>';

if (pg_num_rows($listado) > 0) {
    while ($row = pg_fetch_row($listado)) {
        $data .=
            '<tbody>
                <tr>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-edit icono-pequeno-tabla"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button onclick="agregarEditarMovimiento(' . $row[0] . ')" class="dropdown-item btn btn-light">
                                    <i class="fas fa-edit icon-edit-table"></i> Modificar
                                </button>
                                <button onclick="eliminarMovimiento(' . $row[0] . ')" class="dropdown-item btn btn-light">
                                    <i class="far fa-trash-alt icon-delete-table"></i> Eliminar
                                </button>  
                            </div>
                        </div>
                    </td>
                    <td>' . $row[8] . '</td>  <!-- Número de plaza -->
                    <td>' . $row[6] . '</td>  <!-- Movimiento específico -->
                    <td>' . $row[3] . '</td>  <!-- Fecha de movimiento -->
                    <td>' . $row[1] . '</td>  <!-- Fecha de inicio -->
                    <td>' . $row[2] . '</td>  <!-- Fecha de término -->
                </tr>
            </tbody>';
    }
    $data .= '</table>'; // ✅ Se movió fuera del loop para que la estructura de la tabla sea correcta
} else {
    $data .= '<h6>Sin resultados</h6>';
}

echo $data;

