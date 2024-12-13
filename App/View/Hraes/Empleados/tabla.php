<?php
include '../../../../conexion.php';
include '../../../Model/Hraes/EmpleadosM/EmpleadosM.php';

$listado = new modelEmpleadosHraes();
$paginador = $_POST['paginador'];

$query = $listado->listarByAll($paginador);

if (isset($_POST['busqueda'])) {
    $busqueda = $_POST['busqueda'];
    $query = $listado->listarByLike($busqueda,$paginador);
}

$data =
    '<table class="table table-bordered table-fixed" id="t-table">
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
    </thead>';

if (!$result = pg_query($connectionDBsPro, $query)) {
    exit(pg_result_error($connectionDBsPro));
}
if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_row($result)) {
        $data .=
            '<tbody>
                        <tr>
                            <td class="col-wide-action">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit icono-grande-tabla"></i></button>
                            <div class="dropdown-menu">
                                <button onclick="agregarEditarDetalles(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fas fa-edit icon-edit-table"></i> Modificar</button>
                                <form action="../Modulo/index.php" method="POST">
                                        <input type="hidden" name="id_tbl_empleados_hraes" value="' . $row[0]  . '" />
                                        <button onclick="datosEmpleadosGetDetails(' . $row[0]  . ')" class="dropdown-item btn btn-light"><i class="fa fa-folder-open icon-edit-table"></i> Datos complem.</button>  
                                </form>
                                <button onclick="eliminarEntity(' . $row[0]  . ')" class="dropdown-item btn btn-light"><i class="far fa-trash-alt icon-delete-table"></i> Eliminar</button>  
                            </div>
                          </div>
                                </td>
                            <td class="col-wide-x-150">
                                ' . $row[1] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[2] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[3] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[4] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[5] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[6] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[7] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[8] . ' 
                            </td>
                            <td class="col-wide-x-300">
                                ' . $row[9] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[10] . ' 
                            </td>
                            <td class="col-wide">
                                ' . $row[11] . ' 
                            </td>
                        </tr>
                    </tbody>
                </table>';
    }
}else {
    $data .= '<h6>Sin resultados</h6>';
}

echo $data;


