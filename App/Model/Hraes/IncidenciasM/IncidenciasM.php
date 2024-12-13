<?php


class IncidenciasM
{
    public function listadoByAll($id, $paginator)
    {
        $query = pg_query("SELECT 
                                public.ctrl_incidencias.id_ctrl_incidencias,
                                UPPER(public.cat_incidencias.descripcion),
                                TO_CHAR(public.ctrl_incidencias.fecha_inicio, 'DD/MM/YYYY'),
                                TO_CHAR(public.ctrl_incidencias.fecha_fin, 'DD/MM/YYYY'),
                                UPPER(public.ctrl_incidencias.observaciones),
                                UPPER(public.cat_periodo.descripcion),
                                UPPER(public.users.nombre)
                            FROM public.ctrl_incidencias
                            INNER JOIN public.cat_incidencias
                                ON public.cat_incidencias.id_cat_incidencias =
                                    public.ctrl_incidencias.id_cat_incidencias
                            INNER JOIN public.cat_periodo
                                ON public.ctrl_incidencias.fecha_inicio BETWEEN
                                    public.cat_periodo.fecha_inicio AND public.cat_periodo.fecha_fin
                            LEFT JOIN public.users
                                ON public.users.id_user =
                                    public.ctrl_incidencias.id_user
                            WHERE public.ctrl_incidencias.id_tbl_empleados_hraes = $id
                            ORDER BY public.ctrl_incidencias.fecha_inicio DESC
                            LIMIT 3 OFFSET $paginator;");
        return $query;
    }

    public function listadoBybusqueda($idEmpleado, $busqueda, $paginator)
    {
        $query = pg_query("SELECT 
                                public.ctrl_incidencias.id_ctrl_incidencias,
                                UPPER(public.cat_incidencias.descripcion),
                                TO_CHAR(public.ctrl_incidencias.fecha_inicio, 'DD/MM/YYYY'),
                                TO_CHAR(public.ctrl_incidencias.fecha_fin, 'DD/MM/YYYY'),
                                UPPER(public.ctrl_incidencias.observaciones),
                                UPPER(public.cat_periodo.descripcion),
                                UPPER(public.users.nombre)
                            FROM public.ctrl_incidencias
                            INNER JOIN public.cat_incidencias
                                ON public.cat_incidencias.id_cat_incidencias =
                                    public.ctrl_incidencias.id_cat_incidencias
                            INNER JOIN public.cat_periodo
                                ON public.ctrl_incidencias.fecha_inicio BETWEEN
                                    public.cat_periodo.fecha_inicio AND public.cat_periodo.fecha_fin
                            LEFT JOIN public.users
                                ON public.users.id_user =
                                    public.ctrl_incidencias.id_user
                            WHERE public.ctrl_incidencias.id_tbl_empleados_hraes = $idEmpleado
                            AND (
                                     UPPER(TRIM(UNACCENT(public.cat_incidencias.descripcion)))  LIKE '%$busqueda%' 
                                  OR TO_CHAR(public.ctrl_incidencias.fecha_inicio, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%'
                                  OR TO_CHAR(public.ctrl_incidencias.fecha_fin, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%'
                                  OR UPPER(TRIM(UNACCENT(public.ctrl_incidencias.observaciones))) LIKE '%$busqueda%'
                                  OR UPPER(TRIM(UNACCENT(UPPER(public.cat_periodo.descripcion)))) LIKE '%$busqueda%'
                                )
                            ORDER BY public.ctrl_incidencias.fecha_inicio DESC
                            LIMIT 3 OFFSET $paginator;");
        return $query;
    }

    public function modificarIncidencia($idIncidencia)
    {
        $query = pg_query("SELECT * 
                            FROM public.ctrl_incidencias
                            WHERE public.ctrl_incidencias.id_ctrl_incidencias = $idIncidencia 
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
            'es_mas_de_un_dia' => true
        ];
    }


    //catalago de incidencias
    public function listarCatIncidencias(){
        $query = pg_query ("SELECT 
                                public.cat_incidencias.id_cat_incidencias,
                                UPPER(public.cat_incidencias.descripcion)
                            FROM public.cat_incidencias
                            ORDER BY public.cat_incidencias.id_cat_incidencias ASC;");
        return $query;
    }

    public function editarCatIncidencias($id){
        $query = pg_query ("SELECT 
                                public.cat_incidencias.id_cat_incidencias,
                                UPPER(public.cat_incidencias.descripcion)
                            FROM public.cat_incidencias
                            WHERE public.cat_incidencias.id_cat_incidencias = $id;");
        return $query;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_incidencias', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_incidencias', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_incidencias', $condicion);
        return $pgs_delete;
    }
}
