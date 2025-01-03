<?php
include '../../../../../conexion.php';
include '../../../../Model/Central/AsistenciaM/AsistenciaM.php';

$listado = new AsistenciaM();
$paginador = $_POST['paginador'];

$query = $listado->listarAsistenciaDep($paginador);

if (isset($_POST['busqueda'])) {
    $busqueda = $_POST['busqueda'];
    $query = $listado->listarAsistenciaDepBusqueda($busqueda, $paginador);
}

$data =
    '<table class="table table-bordered table-fixed" id="tabla_asistencias_" style="width:100%">
    <thead>
        <tr>
            <th class="col-wide-action">Acciones</th>
            <th class="col-wide">Nombre</th>
            <th class="col-wide">RFC</th>
            <th class="col-wide">Fecha</th>
            <th class="col-wide">Hora</th>
            <th class="col-wide">Dispositivo</th>
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
                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit icono-grande-tabla"></i></button>
                            <div class="dropdown-menu">
                                <button onclick="getUser(' . $row[5] . ')" class="dropdown-item btn btn-light"><i class="	fa fa-user icon-edit-table"></i> Usuario</button>
                                <button onclick="getDetallesAsistencia(' . $row[7] . ')" class="dropdown-item btn btn-light"><i class="	fa fa-eye icon-edit-table"></i> Ver más</button>
                            </div>
                          </div>
                                </td>
                            <td>
                                ' . $row[0] . '
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