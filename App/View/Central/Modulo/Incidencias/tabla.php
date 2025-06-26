<?php
include '../../../../../conexion.php';
include '../../../../Model/Central/IncidenciasM/IncidenciasM.php';

$id_tbl_empleados_hraes = $_POST['id_tbl_empleados_hraes'];
$paginador = $_POST['paginador'];

$incidenciasM = new IncidenciasM();

// Verifica si hay búsqueda
if (isset($_POST['busqueda']) && trim($_POST['busqueda']) !== '') {
    $listado = $incidenciasM->listadoBybusqueda($id_tbl_empleados_hraes, $_POST['busqueda'], $paginador);
} else {
    $listado = $incidenciasM->listadoByAll($id_tbl_empleados_hraes, $paginador);
}

// Cabecera de la tabla
$data = '
<table class="table table-bordered table-fixed" id="tabla_incidencia">
    <thead class="text-center">
        <tr>
            <th>Acciones</th>
            <th>Tipo incidencia</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Observaciones</th>
        </tr>
    </thead>';

// Contenido de la tabla
if (pg_num_rows($listado) > 0) {
    while ($row = pg_fetch_row($listado)) {
        $data .= '
        <tbody class="text-center">
            <tr>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-edit icono-pequeno-tabla"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button onclick="agregarEditarIncidencia(' . $row[0] . ')" class="dropdown-item btn btn-light">
                                <i class="fas fa-edit icon-edit-table"></i> Modificar
                            </button>
                            <button onclick="eliminarIncidecia(' . $row[0] . ')" class="dropdown-item btn btn-light">
                                <i class="far fa-trash-alt icon-delete-table"></i> Eliminar
                            </button>  
                        </div>
                    </div>
                </td>
                <td>' . htmlspecialchars($row[1]) . '</td>
                <td>' . htmlspecialchars($row[2]) . '</td>
                <td>' . htmlspecialchars($row[3]) . '</td>
                <td>' . htmlspecialchars($row[4]) . '</td>
            </tr>
        </tbody>';
    }

    $data .= '</table>';
} else {
    $data .= '<h6 class="text-center">Sin resultados</h6>';
}

// Imprime la tabla final
echo $data;
