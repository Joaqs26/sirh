<?php


class IncidenciasM
{
   public function listadoByAll($id, $paginator)
{
    $query = pg_query("SELECT 
            i.id_ctrl_incidencias,
            COALESCE(UPPER(i.otro_cat_incidencias), UPPER(ci.descripcion)) AS tipo_incidencia,
            TO_CHAR(i.fecha_inicio, 'DD/MM/YYYY') AS fecha_inicio,
            TO_CHAR(i.fecha_fin, 'DD/MM/YYYY') AS fecha_fin,
            UPPER(i.observaciones) AS observaciones
        FROM central.ctrl_incidencias i
        LEFT JOIN central.cat_incidencias ci
            ON ci.id_cat_incidencias = i.id_cat_incidencias
        WHERE i.id_tbl_empleados_hraes = $id
        ORDER BY i.fecha_inicio DESC
        LIMIT 3 OFFSET $paginator;
    ");
    return $query;
}


    public function listadoBybusqueda($idEmpleado, $busqueda, $paginator)
{
    $query = pg_query("SELECT 
            i.id_ctrl_incidencias,
            COALESCE(UPPER(i.otro_cat_incidencias), UPPER(ci.descripcion)) AS tipo_incidencia,
            TO_CHAR(i.fecha_inicio, 'DD/MM/YYYY') AS fecha_inicio,
            TO_CHAR(i.fecha_fin, 'DD/MM/YYYY') AS fecha_fin,
            UPPER(i.observaciones) AS observaciones
        FROM central.ctrl_incidencias i
        LEFT JOIN central.cat_incidencias ci
            ON ci.id_cat_incidencias = i.id_cat_incidencias
        WHERE i.id_tbl_empleados_hraes = $idEmpleado
          AND (
              COALESCE(UPPER(TRIM(UNACCENT(i.otro_cat_incidencias))), UPPER(TRIM(UNACCENT(ci.descripcion)))) LIKE '%$busqueda%' 
              OR TO_CHAR(i.fecha_inicio, 'DD/MM/YYYY') LIKE '%$busqueda%'
              OR TO_CHAR(i.fecha_fin, 'DD/MM/YYYY') LIKE '%$busqueda%'
              OR UPPER(TRIM(UNACCENT(i.observaciones))) LIKE '%$busqueda%'
          )
        ORDER BY i.fecha_inicio DESC
        LIMIT 3 OFFSET $paginator;
    ");
    return $query;
}


  public function modificarIncidencia($idIncidencia)
{
    $query = pg_query("SELECT * 
                        FROM central.ctrl_incidencias
                        WHERE central.ctrl_incidencias.id_ctrl_incidencias = $idIncidencia 
                        LIMIT 1;");
    return $query;
}


    public function listarByNull()
    {
        return $array = [
            'id_ctrl_incidencias' => null,
            'fecha_inicio' => null,
            'fecha_fin' => null,
            'fecha_captura' => null,
            'hora' => null,
            'observaciones' => null,
            'otro_cat_incidencias' => null,
            'id_tbl_empleados_hraes' => null,
            'id_cat_incidencias' => null,
            'es_mas_de_un_dia' => true,
            'num_oficio' => null, 
        ];
    }


    //catalago de incidencias
    public function listarCatIncidencias(){
            $query = pg_query ("SELECT 
                                    central.cat_incidencias.id_cat_incidencias,
                                    UPPER(central.cat_incidencias.descripcion)
                                FROM central.cat_incidencias
                                ORDER BY central.cat_incidencias.id_cat_incidencias ASC;");
        return $query;
    }

    public function editarCatIncidencias($id){
        $query = pg_query ("SELECT 
                                central.cat_incidencias.id_cat_incidencias,
                                UPPER(central.cat_incidencias.descripcion)
                            FROM central.cat_incidencias
                            WHERE central.cat_incidencias.id_cat_incidencias = $id;");
        return $query;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'central.ctrl_incidencias', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'central.ctrl_incidencias', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'central.ctrl_incidencias', $condicion);
        return $pgs_delete;
    }
}
