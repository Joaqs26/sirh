<?php
include '../../../../../conexion.php';
include '../../../../Model/Hraes/FaltaM/FaltaM.php';

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];
$paginador = $_POST['paginador'];

$faltaModelM = new FaltaModelM();
$listado = $faltaModelM->listarById($id_tbl_empleados_hraes, $paginador);

if (isset($_POST['busqueda'])) {
    $listado = $faltaModelM->listarByBusqueda($id_tbl_empleados_hraes, $_POST['busqueda'], $paginador);
}


$data =
    '<table class="table table-bordered table-fixed" id="tabla_retardo" style="width:100%">
    <thead class="text-center">
        <tr>
            <th class="col-wide-action">Acciones</th>
            <th class="col-wide">Tipo de falta</th>
            <th class="col-wide">Fecha (Desde)</th>
            <th class="col-wide">Fecha (Hasta)</th>
            <th class="col-wide">Fecha (Registro)</th>
            <th class="col-wide">Fecha (Retardo)</th>
            <th class="col-wide">Hora (Retardo)</th>
            <th class="col-wide">Código de certificación</th>
            <th class="col-wide">Estatus</th>
            <th class="col-wide">Tipo</th>
            <th class="col-wide">Observaciones</th>
        </tr>
    </thead>';

if (pg_num_rows($listado) > 0) {
    while ($row = pg_fetch_row($listado)) {
        $data .=
            '<tbody class="text-center">
                        <tr>
                        <td>
                        <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit icono-pequeno-tabla"></i></button>
                            <div class="dropdown-menu">
                                <button onclick="obtenerUsuario(' . $row[0] . ')" class="dropdown-item btn btn-light" disabled><i class="fa fa-user icon-edit-table"></i> Usuario</button>
                                <button onclick="agregarEditarFalta(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fas fa-edit icon-edit-table"></i> Modificar</button>
                                <button onclick="eliminarFalta(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="far fa-trash-alt icon-delete-table"></i> Eliminar</button>  
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
                                ' . $row[5] . '
                            </td>
                            <td>
                                ' . $row[6] . '
                            </td>
                            <td>
                                ' . $row[7] . '
                            </td>
                            <td>
                                ' . $row[8] . '
                            </td>
                            <td>
                                ' . $row[9] . '
                            </td>
                            <td>
                                ' . $row[10] . '
                            </td>
                        </tr>
                    </tbody>
                </table>';
    }
} else {
    $data .= '<h6>Sin resultados</h6>';
}

echo $data;
