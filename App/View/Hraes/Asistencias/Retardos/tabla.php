<?php
include '../../../../../conexion.php';
include '../../../../Model/Hraes/RetardoM/RetardoM.php';

$listado = new ModelRetardoM();
$paginador = $_POST['paginador'];

$query = $listado->listadoAllFaltas($paginador);

if (isset($_POST['busqueda'])) {
    $busqueda = $_POST['busqueda'];
    $query = $listado->listadoAllFaltasBusqueda($busqueda, $paginador);
}

$data =
    '<table class="table table-bordered table-fixed" id="tabla_faltas_" style="width:100%">
    <thead>
        <tr>
            <th class="col-wide-action">Acciones</th>
            <th class="col-wide">Nombre</th>
            <th class="col-wide">RFC</th>
            <th class="col-wide">Fecha</th>
            <th class="col-wide">Hora</th>
            <th class="col-wide">Tipo</th>
            <th class="col-wide">Estatus</th>
            <th class="col-wide">Observaciones</th>
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
                                <button onclick="getUser(' . $row[7] . ')" class="dropdown-item btn btn-light"><i class="	fa fa-user icon-edit-table"></i> Usuario</button>
                                <button onclick="mostrarRetardo()" class="dropdown-item btn btn-light"><i class="fas fa-edit icon-edit-table"></i> Modificar</button>
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
                                ' . $row[5] . '
                            </td>
                            <td>
                                ' . $row[6] . '
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