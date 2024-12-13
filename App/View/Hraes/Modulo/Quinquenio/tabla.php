<?php
include '../../../../../conexion.php';
include '../../../../Model/Hraes/QuinquenioM/QuinquenioM.php';

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];

$modelQuinquenioM = new ModelQuinquenioM();
$listado = $modelQuinquenioM->listarById($id_tbl_empleados_hraes);

$data =
    '<table lass="table table-bordered table-fixed" id="tabla_quinquenio" style="width:100%">
    <thead class="text-center">
        <tr>
            <th class="col-wide-action">Acciones</th>
            <th class="col-wide">Importe</th>
            <th class="col-wide">Fecha</th>
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
                            <button onclick="agregarEditarQuinquenio(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fas fa-edit icon-edit-table"></i> Modificar</button>
                            <button onclick="eliminarQuinquenio(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="far fa-trash-alt icon-delete-table"></i> Eliminar</button>  
                        </div>
                      </div>
                                </td>
                            <td>
                                ' . $row[2] . '
                            </td>
                            <td>
                                ' . $fecha = date("d-m-y", strtotime($row[1]))   . '
                            </td>
                        </tr>
                    </tbody>
                </table>';
    }
} else {
    $data .= '<h6>Sin resultados</h6>';
}

echo $data;
