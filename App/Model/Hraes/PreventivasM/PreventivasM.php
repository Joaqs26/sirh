<?php

class PreventivasM
{

    public function listadoByAll($id_tbl_empleados_hraes, $paginador)
    {
        $query = pg_query("SELECT 
                                public.ctrl_preventivas.id_ctrl_preventivas,
                                UPPER(central.cat_preventivas.descripcion) AS estatus,
                                UPPER(public.ctrl_preventivas.no_oficio),
                                TO_CHAR(public.ctrl_preventivas.fecha_inicio, 'DD/MM/YYYY'),
                                TO_CHAR(public.ctrl_preventivas.fecha_fin, 'DD/MM/YYYY'),
                                central.cat_quincenas.nombre AS quincena,
                                CONCAT (TO_CHAR(central.cat_quincenas.fecha_inicio, 'DD/MM/YYYY'), ' - ',
                                        TO_CHAR(central.cat_quincenas.fecha_fin, 'DD/MM/YYYY')) AS periodo_quincena,
                                UPPER(public.ctrl_preventivas.observaciones)
                            FROM public.ctrl_preventivas
                            INNER JOIN central.cat_quincenas
                                ON public.ctrl_preventivas.fecha_inicio BETWEEN 
                                    central.cat_quincenas.fecha_inicio AND central.cat_quincenas.fecha_fin	
                            INNER JOIN central.cat_preventivas
                                ON	public.ctrl_preventivas.id_cat_preventivas =
                                    central.cat_preventivas.id_cat_preventivas
                            WHERE public.ctrl_preventivas.id_tbl_empleados_hraes = $id_tbl_empleados_hraes -- IS ID_EMPLOYEE
                            ORDER BY central.cat_quincenas.fecha_inicio DESC
                            LIMIT 3 OFFSET $paginador;");
        return $query;
    }

    public function listadoBybusqueda($id_tbl_empleados_hraes, $busqueda, $paginador)
    {
        $query = pg_query("SELECT 
                                public.ctrl_preventivas.id_ctrl_preventivas,
                                UPPER(central.cat_preventivas.descripcion) AS estatus,
                                UPPER(public.ctrl_preventivas.no_oficio),
                                TO_CHAR(public.ctrl_preventivas.fecha_inicio, 'DD/MM/YYYY'),
                                TO_CHAR(public.ctrl_preventivas.fecha_fin, 'DD/MM/YYYY'),
                                central.cat_quincenas.nombre AS quincena,
                                CONCAT (TO_CHAR(central.cat_quincenas.fecha_inicio, 'DD/MM/YYYY'), ' - ',
                                        TO_CHAR(central.cat_quincenas.fecha_fin, 'DD/MM/YYYY')) AS periodo_quincena,
                                UPPER(public.ctrl_preventivas.observaciones)
                            FROM public.ctrl_preventivas
                            INNER JOIN central.cat_quincenas
                                ON public.ctrl_preventivas.fecha_inicio BETWEEN 
                                    central.cat_quincenas.fecha_inicio AND central.cat_quincenas.fecha_fin	
                            INNER JOIN central.cat_preventivas
                                ON	public.ctrl_preventivas.id_cat_preventivas =
                                    central.cat_preventivas.id_cat_preventivas
                            WHERE public.ctrl_preventivas.id_tbl_empleados_hraes = $id_tbl_empleados_hraes -- IS ID_EMPLOYEE
                            AND (
                                UPPER(TRIM(UNACCENT(central.cat_preventivas.descripcion))) LIKE '%$busqueda%' OR
                                UPPER(TRIM(UNACCENT(public.ctrl_preventivas.no_oficio))) LIKE '%$busqueda%' OR
                                TO_CHAR(public.ctrl_preventivas.fecha_inicio, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                TO_CHAR(public.ctrl_preventivas.fecha_fin, 'DD/MM/YYYY')::TEXT LIKE '%$busqueda%' OR
                                UPPER(TRIM(UNACCENT(central.cat_quincenas.nombre))) LIKE '%$busqueda%' OR
                                UPPER(TRIM(UNACCENT(public.ctrl_preventivas.observaciones))) LIKE '%$busqueda%' 
                            )
                            ORDER BY central.cat_quincenas.fecha_inicio DESC
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
                                central.cat_preventivas.id_cat_preventivas,
                                UPPER(central.cat_preventivas.descripcion)
                            FROM central.cat_preventivas
                            ORDER BY central.cat_preventivas.descripcion ASC;");
        return $query;
    }

    public function editCatPreventivas($id)
    {
        $query = pg_query("SELECT 
                                central.cat_preventivas.id_cat_preventivas,
                                UPPER(central.cat_preventivas.descripcion)
                            FROM central.cat_preventivas
                            WHERE central.cat_preventivas.id_cat_preventivas = $id;");
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