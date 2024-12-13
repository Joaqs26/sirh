<?php
include '../../../../conexion.php';
include '../../../Model/Hraes/PlazasM/PlazasM.php';

$listado = new modelPlazasHraes();
//$query = $listado->listarByAll(); //INICIO DE LA TABLA CON LA INFORMACION
$busqueda = $_POST['busqueda'];
$paginador = $_POST['paginador'];
$id_tbl_centro_trabajo_hraes = $_POST['id_tbl_centro_trabajo_hraes'];

if ($id_tbl_centro_trabajo_hraes != null) {///LISTAR CON ID DE CENTRO DE TRABAJO
    if ($busqueda != '') { ///LISTAR CON BUSQUEDA
        $query = $listado->listarByLike($id_tbl_centro_trabajo_hraes, $busqueda, $paginador);
    } else { ///LISTAR SIN BUSQUEDA
        $query = $listado->listarByAll($id_tbl_centro_trabajo_hraes, $paginador);
    }
} else { ///LISTAR SIN ID DE CENTRO DE TRABAJO
    if ($busqueda != '') { ///LISTAR CON BUSQUEDA
        $query = $listado->listarByLike($id_tbl_centro_trabajo_hraes, $busqueda, $paginador);
    } else { ///LISTAR SIN BUSQUEDA
        $query = $listado->listarByAll($id_tbl_centro_trabajo_hraes, $paginador);
    }
}

$data =
    '<table class="table table-bordered table-fixed" id="tabla_plazas" style="width:100%">
    <thead>
        <tr>
            <th class="col-wide-action">Acciones</th>
            <th class="col-wide">No Plaza</th>
            <th class="col-wide">Tipo de plaza</th>
            <th class="col-wide-x-300">Nombre del puesto</th>
            <th class="col-wide">Puesto</th>
            <th class="col-wide">Nivel</th>
            <th class="col-wide">CLUES</th>
            <th class="col-wide">Tipo de contratación</th>
            <th class="col-wide">Tipo de trabajador</th>
            <th class="col-wide-x-300">Unidad responsable</th>
        </tr>
    </thead>';

if (!$result = pg_query($connectionDBsPro, $query)) {
    exit(pg_result_error($connectionDBsPro));
}
if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_row($result)) {

        //funcion para validar el id de usuario y fecha de captura no este vaia
        $id_user = empty($row[10]) ? 'false' : $row[10];
        $date = empty($row[11]) ? 'false' : date("Y-m-d", strtotime($row[11]))."T00:00:00";
        //$hour = empty($row[11]) ? 'false' : date("H:i", strtotime($row[11]));
        $hour = 'false';

        $data .=
            '<tbody style="background-color: white;">
                        <tr>
                        <td>
                            <div class="btn-group">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit icono-grande-tabla"></i></button>
                        <div class="dropdown-menu">
                            <button onclick="agregarEditarDetalles(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fas fa-edit icon-edit-table"></i> Modificar</button>
                            <!--
                            <button onclick="detallesPlazaModal(' . $row[0] . ')" class="dropdown-item btn btn-light"><i class="fa fa-align-left icon-edit-table"></i> Especificaciones</button>
                            -->
                            <button onclick="isGetUser(' . $id_user . ' , ' . $date . ' , ' . $hour . ')" class="dropdown-item btn btn-light"><i class="fa fa-user icon-edit-table"></i> Usuario</button>
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
                        </tr>
                    </tbody>
                </table>';
    }
} else {
    $data .= '<h6>Sin resultados</h6>';
}
echo $data;


