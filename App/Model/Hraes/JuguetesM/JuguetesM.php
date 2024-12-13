<?php

class ModelJuguetesM
{
    public function listarById($id_object,$paginator)
    {
        $listado = pg_query("SELECT ctrl_juguetes_hraes.id_ctrl_juguetes_hraes,
                                    CONCAT(ctrl_dependientes_economicos_hraes.nombre, ' ',
                                    ctrl_dependientes_economicos_hraes.apellido_paterno, ' ',
                                    ctrl_dependientes_economicos_hraes.apellido_materno,' '),
                                    cat_fecha_juguetes.fecha,
                                    cat_estatus_juguetes.estatus
                            FROM public.ctrl_juguetes_hraes
                            INNER JOIN cat_fecha_juguetes
                            ON public.ctrl_juguetes_hraes.id_cat_fecha_juguetes = 
                                cat_fecha_juguetes.id_cat_fecha_juguetes
                            INNER JOIN cat_estatus_juguetes
                            ON public.ctrl_juguetes_hraes.id_cat_estatus_juguetes = 
                                cat_estatus_juguetes.id_cat_estatus_juguetes
                            INNER JOIN public.ctrl_dependientes_economicos_hraes
                            ON public.ctrl_juguetes_hraes.id_ctrl_dependientes_economicos_hraes = 
                                public.ctrl_dependientes_economicos_hraes.id_ctrl_dependientes_economicos_hraes
                            WHERE public.ctrl_juguetes_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY public.ctrl_juguetes_hraes.id_ctrl_juguetes_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    public function listarByNull()
    {
        return $raw = [
            'id_ctrl_juguetes_hraes' => null,
            'id_cat_fecha_juguetes' => null,
            'id_cat_estatus_juguetes' => null,
            'id_tbl_empleados_hraes' => null,
            'id_ctrl_dependientes_economicos_hraes' => null
        ];
    }

    public function listarEditById($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_juguetes_hraes,id_cat_fecha_juguetes,
                                    id_cat_estatus_juguetes,id_tbl_empleados_hraes,
                                    id_ctrl_dependientes_economicos_hraes
                             FROM public.ctrl_juguetes_hraes
                             WHERE id_ctrl_juguetes_hraes = $id_object");
        return $listado;
    }

    public function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_juguetes_hraes', $datos, $condicion);
        return $pg_update;
    }

    public function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_juguetes_hraes', $datos);
        return $pg_add;
    }

    public function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_juguetes_hraes', $condicion);
        return $pgs_delete;
    }

    public function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT public.ctrl_juguetes_hraes.id_ctrl_juguetes_hraes,
                                    CONCAT(ctrl_dependientes_economicos_hraes.nombre, ' ',
                                    ctrl_dependientes_economicos_hraes.apellido_paterno, ' ',
                                    ctrl_dependientes_economicos_hraes.apellido_materno,' '),
                                    cat_fecha_juguetes.fecha,
                                    cat_estatus_juguetes.estatus
                            FROM public.ctrl_juguetes_hraes
                            INNER JOIN cat_fecha_juguetes
                            ON public.ctrl_juguetes_hraes.id_cat_fecha_juguetes = 
                                cat_fecha_juguetes.id_cat_fecha_juguetes
                            INNER JOIN cat_estatus_juguetes
                            ON public.ctrl_juguetes_hraes.id_cat_estatus_juguetes = 
                                cat_estatus_juguetes.id_cat_estatus_juguetes
                            INNER JOIN public.ctrl_dependientes_economicos_hraes
                            ON public.ctrl_juguetes_hraes.id_ctrl_dependientes_economicos_hraes = 
                                public.ctrl_dependientes_economicos_hraes.id_ctrl_dependientes_economicos_hraes
                            WHERE public.ctrl_juguetes_hraes.id_tbl_empleados_hraes = $id_object
                            AND (TRIM(UPPER(UNACCENT(ctrl_dependientes_economicos_hraes.nombre))) 
                                    LIKE '%$busqueda%' OR
                                TRIM(UPPER(UNACCENT(ctrl_dependientes_economicos_hraes.apellido_paterno))) 
                                    LIKE '%$busqueda%' OR
                                TRIM(UPPER(UNACCENT(ctrl_dependientes_economicos_hraes.apellido_materno))) 
                                    LIKE '%$busqueda%' OR
                                TRIM(UPPER(UNACCENT(cat_fecha_juguetes.fecha))) 
                                    LIKE '%$busqueda%' OR
                                TRIM(UPPER(UNACCENT(cat_estatus_juguetes.estatus))) 
                                    LIKE '%$busqueda%'
                            )
                            ORDER BY public.ctrl_juguetes_hraes.id_ctrl_juguetes_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    public function validarMenorAdd($curp,$id_cat_fecha)
    {
        $listado = pg_query("SELECT COUNT (ctrl_juguetes_hraes.id_ctrl_juguetes_hraes)
                                    FROM public.ctrl_juguetes_hraes
                                    INNER JOIN public.ctrl_dependientes_economicos_hraes
                                    ON public.ctrl_juguetes_hraes.id_ctrl_dependientes_economicos_hraes =
                                        public.ctrl_dependientes_economicos_hraes.id_ctrl_dependientes_economicos_hraes
                                    WHERE public.ctrl_dependientes_economicos_hraes.curp = '$curp'
                                    AND public.ctrl_juguetes_hraes.id_cat_fecha_juguetes = $id_cat_fecha;");
        return $listado;
    }

    public function validarMenorEdit($curp,$id_cat_fecha,$id_object)
    {
        $listado = pg_query("SELECT COUNT (ctrl_juguetes_hraes.id_ctrl_juguetes_hraes)
                            FROM public.ctrl_juguetes_hraes
                            INNER JOIN public.ctrl_dependientes_economicos_hraes
                            ON public.ctrl_juguetes_hraes.id_ctrl_dependientes_economicos_hraes =
                                public.ctrl_dependientes_economicos_hraes.id_ctrl_dependientes_economicos_hraes
                            WHERE public.ctrl_dependientes_economicos_hraes.curp = '$curp'
                            AND ctrl_juguetes_hraes.id_cat_fecha_juguetes = $id_cat_fecha
                            AND ctrl_juguetes_hraes.id_ctrl_juguetes_hraes <> $id_object;");
        return $listado;
    }
}
