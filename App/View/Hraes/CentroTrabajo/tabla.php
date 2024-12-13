<?php
include '../../../../conexion.php';
include '../../../Model/Hraes/CentroTrabajoM/CentroTrabajoM.php';

$listado = new modelCentroTrabajoHraes();
$paginador = $_POST['paginador'];

$query = $listado->listarByAll($paginador);

if (isset($_POST['busqueda'])) {
    $busqueda = $_POST['busqueda'];
    $query = $listado->listarByLike($busqueda, $paginador);
}

$data =
    '<table class="table table-bordered table-fixed" id="t-table" style="width:100%">
    <thead>
        <tr>
            <th class="col-wide-action">Acciones</th>
            <th class="col-wide">Centro de trabajo</th>
            <th class="col-wide-x-300">Nombre</th>
            <th class="col-wide">Entidad</th>
            <th class="col-wide">C&oacutedigo postal</th>
            <th class="col-wide">Total de plazas</th>
        </tr>
    </thead>';

if (!$result = pg_query($connectionDBsPro, $query)) {
    exit(pg_result_error($connectionDBsPro));
}
if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_row($result)) {
        $id_tbl_centro_trabajo_hraes = base64_encode($row[0]);
        $isAllPlaza = returnArrayById($listado->allCountPlazas($row[0]));
        $data .=
            '<tbody>
                        <tr>
                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit icono-grande-tabla"></i></button>
                            <div class="dropdown-menu">
                                <button onclick="agregarEditarDetalles(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fas fa-edit icon-edit-table"></i> Modificar</button>
                                <button onclick="isGetUser()" class="dropdown-item btn btn-light" disabled><i class="fa fa-user icon-edit-table"></i> Usuario</button>
                                <form action="../Plazas/index.php" method="POST">
                                        <input type="hidden" name="id_tbl_centro_trabajo_hraes" value="' . $row[0] . '" />
                                        <button class="dropdown-item btn btn-light"><i class="fa fa-bookmark icon-edit-table"></i> Plazas</button>  
                                </form>
                                <button onclick="eliminarEntity(' . $row[0] . ')" class="dropdown-item btn btn-light" disabled><i class="far fa-trash-alt icon-delete-table"></i> Eliminar</button>  
                            </div>
                          </div>
                                </td>
                            <td>
                                ' . $row[1] . '
                            </td>
                            <td>
                                ' . $row[2] . '
                            </td>
                            <td>
                                ' . $row[3] . '
                            </td>
                            <td>
                                ' . $row[4] . '
                            </td>
                            <td>
                                ' . $isAllPlaza[0] . '
                            </td>
                        </tr>
                    </tbody>
                </table>';
    }
} else {
    $data .= '<h6>Sin resultados</h6>';
}

echo $data;


function returnArrayById($result)
{
    if (pg_num_rows($result) > 0) {
        while ($row = pg_fetch_row($result)) {
            $response = $row;
        }
    }
    return $response;
}