<?php
include '../../../../../conexion.php';
include '../../../../Model/Hraes/RetardoM/RetardoM.php';

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];
$paginador = $_POST['paginador'];

$modelRetardoM = new ModelRetardoM();
$listado = $modelRetardoM ->listarById($id_tbl_empleados_hraes,$paginador);

if(isset($_POST['busqueda'])){
    $listado = $modelRetardoM->listarByBusqueda($id_tbl_empleados_hraes,$_POST['busqueda'],$paginador);
}

function concatFecha($fecha1, $fecha2){
    $fecha = "";
    if (isset($fecha1)){
        $fecha = $fecha1 . ':' .$fecha2;
    }
    return $fecha;
}

$data =
    '<table class="table table-bordered table-fixed" id="tabla_retardo" style="width:100%">
    <thead class="text-center">
        <tr>
            <th class="col-wide-action">Acciones</th>
            <th class="col-wide">Fecha</th>
            <th class="col-wide">Hora</th>
            <th class="col-wide">Tipo</th>
            <th class="col-wide">Estatus</th>
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
                                <button onclick="obtenerUsuario(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fa fa-user icon-edit-table"></i> Usuario</button>
                                <button onclick="agregarEditarRetardo(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fas fa-edit icon-edit-table"></i> Modificar</button>
                                <button onclick="eliminarRetardo_(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="far fa-trash-alt icon-delete-table"></i> Eliminar</button>  
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
                        </tr>
                    </tbody>
                </table>';
    }
} else {
    $data .= '<h6>Sin resultados</h6>';
}

echo $data;
