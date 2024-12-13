<?php

class PreventivasM
{

    public function listadoByAll($id_tbl_empleados_hraes, $paginador)
    {
        $query = pg_query("SELECT 
                                public.ctrl_preventivas.id_ctrl_preventivas,
                                UPPER(public.cat_preventivas.descripcion) AS estatus,
                                UPPER(public.ctrl_preventivas.no_oficio),
                                TO_CHAR(public.ctrl_preventivas.fecha_inicio, 'DD/MM/YYYY'),
                                TO_CHAR(public.ctrl_preventivas.fecha_fin, 'DD/MM/YYYY'),
                                public.cat_quincenas.nombre AS quincena,
                                CONCAT (TO_CHAR(public.cat_quincenas.fecha_inicio, 'DD/MM/YYYY'), ' - ',
                                        TO_CHAR(public.cat_quincenas.fecha_fin, 'DD/MM/YYYY')) AS periodo_quincena,
                                UPPER(public.ctrl_preventivas.observaciones)
                            FROM public.ctrl_preventivas
                            INNER JOIN public.cat_quincenas
                                ON public.ctrl_preventivas.fecha_inicio BETWEEN 
                                    public.cat_quincenas.fecha_inicio AND public.cat_quincenas.fecha_fin	
                            INNER JOIN public.cat_preventivas
                                ON	public.ctrl_preventivas.id_cat_preventivas =
                                    public.cat_preventivas.id_cat_preventivas
                            WHERE public.ctrl_preventivas.id_tbl_empleados_hraes = $id_tbl_empleados_hraes -- IS ID_EMPLOYEE
                            ORDER BY public.cat_quincenas.fecha_inicio DESC
                            LIMIT 3 OFFSET $paginador;");
        return $query;
    }

    public function listadoBybusqueda($id_tbl_empleados_hraes, $busqueda, $paginador)
    {
        $query = pg_query("SELECT 
                                public.ctrl_preventivas.id_ctrl_preventivas,
                                UPPER(public.cat_preventivas.descripcion) AS estatus,
                                UPPER(public.ctrl_preventivas.no_oficio),
                                TO_CHAR(public.ctrl_preventivas.fecha_inicio, 'DD/MM/YYYY'),
                                TO_CHAR(public.ctrl_preventivas.fecha_fin, 'DD/MM/YYYY'),
                                public.cat_quincenas.nombre AS quincena,
                                CONCAT (TO_CHAR(public.cat_quincenas.fecha_inicio, 'DD/MM/YYYY'), ' - ',
                                        TO_CHAR(public.cat_quincenas.fecha_fin, 'DD/MM/YYYY')) AS periodo_quincena,
                                UPPER(public.ctrl_preventivas.observaciones)
                            FROM public.ctrl_preventivas
                            INNER JOIN public.cat_quincenas
                                ON public.ctrl_preventivas.fecha_inicio BETWEEN 
                                    public.cat_quincenas.fecha_inicio AND public.cat_quincenas.fecha_fin	
                            INNER JOIN public.cat_preventivas
                                ON	public.ctrl_preventivas.id_cat_preventivas =
                                    public.cat_preventivas.id_cat_preventivas
                            WHERE public.ctrl_preventivas.id_tbl_empleados_hraes = $id_tbl_empleados_hraes -- IS ID_EMPLOYEE
                            AND (
                                UPPER(TRIM(UNACCENT(public.cat_preventivas.descripcion))) LIKE '%$busqueda%' OR
                                UPPER(TRIM(UNACCENT(public.ctrl_preventivas.no_oficio))) LIKE '%$busqueda%' OR
                                TO_CHAR(public.ctrl_preventivas.fecha_inicio, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                TO_CHAR(public.ctrl_preventivas.fecha_fin, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                UPPER(TRIM(UNACCENT(public.cat_quincenas.nombre))) LIKE '%$busqueda%' OR
                                UPPER(TRIM(UNACCENT(public.ctrl_preventivas.observaciones))) LIKE '%$busqueda%' 
                            )
                            ORDER BY public.cat_quincenas.fecha_inicio DESC
                            LIMIT 3 OFFSET $paginador;");
        return $query;
    }

    public function listarByNull()
    {
        return $array = [
            'id_ctrl_preventivas' => NULL,
            'no_oficio' => NULL,
            'cuenta_clabe' => NULL,
            'observaciones' => NULL,
            'fecha_inicio' => NULL,
            'fecha_fin' => NULL,
            'id_cat_preventivas' => NULL
        ];
    }

    public function listarCatPreventivas()
    {
        $query = pg_query("SELECT 
                                public.cat_preventivas.id_cat_preventivas,
                                UPPER(public.cat_preventivas.descripcion)
                            FROM public.cat_preventivas
                            ORDER BY public.cat_preventivas.descripcion ASC;");
        return $query;
    }

    public function editCatPreventivas($id)
    {
        $query = pg_query("SELECT 
                                public.cat_preventivas.id_cat_preventivas,
                                UPPER(public.cat_preventivas.descripcion)
                            FROM public.cat_preventivas
                            WHERE public.cat_preventivas.id_cat_preventivas = $id;");
        return $query;
    }

    public function getDetails($id)
    {
        $query = pg_query("SELECT * 
                            FROM public.ctrl_preventivas
                            WHERE id_ctrl_preventivas = $id;");
        return $query;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_preventivas', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_preventivas', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_preventivas', $condicion);
        return $pgs_delete;
    }
}