<?php

class ModelPercepcionesM
{

    public function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT ctrl_percepciones_hraes.id_ctrl_percepciones_hraes,
                                    cat_concepto.concepto,
                                    cat_valores.valor,
                                    ctrl_percepciones_hraes.fecha_registro
                            FROM public.ctrl_percepciones_hraes
                            INNER JOIN cat_valores
                            ON ctrl_percepciones_hraes.id_cat_valores =
                                cat_valores.id_cat_valores
                            INNER JOIN cat_concepto
                            ON cat_valores.id_cat_concepto =
                                cat_concepto.id_cat_concepto
                            WHERE ctrl_percepciones_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY cat_concepto.concepto ASC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    public function listarByNull()
    {
        return $raw = [
            'id_ctrl_percepciones_hraes' => null,
            'id_tbl_empleados_hraes' => null,
            'id_cat_valores' => null,
            'fecha_registro' => null
        ];
    }

    public function listarEditById($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_percepciones_hraes,id_tbl_empleados_hraes,
                                    id_cat_valores,fecha_registro
                             FROM public.ctrl_percepciones_hraes
                             WHERE id_ctrl_percepciones_hraes = $id_object");
        return $listado;
    }

    function validarConcepto($id_cat_concepto,$id_tbl_empleados_hraes,$id_object)
    {
        $condition = ';'; //->separator
        if($id_object != null){
            $condition = ' AND public.ctrl_percepciones_hraes.id_ctrl_percepciones_hraes != ' . $id_object;
        }

        $listado = pg_query("SELECT COUNT (id_ctrl_percepciones_hraes)
                             FROM public.ctrl_percepciones_hraes
                             INNER JOIN cat_valores
                             ON public.ctrl_percepciones_hraes.id_cat_valores =
                                 cat_valores.id_cat_valores
                             INNER JOIN cat_concepto
                             ON cat_valores.id_cat_concepto =
                                 cat_concepto.id_cat_concepto
                             WHERE public.ctrl_percepciones_hraes.id_tbl_empleados_hraes = $id_tbl_empleados_hraes
                             AND cat_concepto.id_cat_concepto = $id_cat_concepto" . $condition);
        return $listado;
    }

    public function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_percepciones_hraes', $datos, $condicion);
        return $pg_update;
    }

    public function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_percepciones_hraes', $datos);
        return $pg_add;
    }

    public function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_percepciones_hraes', $condicion);
        return $pgs_delete;
    }







    /*
    

    

    

    

    public function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT ctrl_juguetes_hraes.id_ctrl_juguetes_hraes,
                                    CONCAT(ctrl_dependientes_economicos_hraes.nombre, ' ',
                                    ctrl_dependientes_economicos_hraes.apellido_paterno, ' ',
                                    ctrl_dependientes_economicos_hraes.apellido_materno,' '),
                                    cat_fecha_juguetes.fecha,
                                    cat_estatus_juguetes.estatus
                            FROM ctrl_juguetes_hraes
                            INNER JOIN cat_fecha_juguetes
                            ON ctrl_juguetes_hraes.id_cat_fecha_juguetes = 
                                cat_fecha_juguetes.id_cat_fecha_juguetes
                            INNER JOIN cat_estatus_juguetes
                            ON ctrl_juguetes_hraes.id_cat_estatus_juguetes = 
                                cat_estatus_juguetes.id_cat_estatus_juguetes
                            INNER JOIN ctrl_dependientes_economicos_hraes
                            ON ctrl_juguetes_hraes.id_ctrl_dependientes_economicos_hraes = 
                                ctrl_dependientes_economicos_hraes.id_ctrl_dependientes_economicos_hraes
                            WHERE ctrl_juguetes_hraes.id_tbl_empleados_hraes = $id_object
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
                            ORDER BY ctrl_juguetes_hraes.id_ctrl_juguetes_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    public function validarMenorAdd($curp,$id_cat_fecha)
    {
        $listado = pg_query("SELECT COUNT (ctrl_juguetes_hraes.id_ctrl_juguetes_hraes)
                                    FROM ctrl_juguetes_hraes
                                    INNER JOIN ctrl_dependientes_economicos_hraes
                                    ON ctrl_juguetes_hraes.id_ctrl_dependientes_economicos_hraes =
                                        ctrl_dependientes_economicos_hraes.id_ctrl_dependientes_economicos_hraes
                                    WHERE ctrl_dependientes_economicos_hraes.curp = '$curp'
                                    AND ctrl_juguetes_hraes.id_cat_fecha_juguetes = $id_cat_fecha;");
        return $listado;
    }

    public function validarMenorEdit($curp,$id_cat_fecha,$id_object)
    {
        $listado = pg_query("SELECT COUNT (ctrl_juguetes_hraes.id_ctrl_juguetes_hraes)
                            FROM ctrl_juguetes_hraes
                            INNER JOIN ctrl_dependientes_economicos_hraes
                            ON ctrl_juguetes_hraes.id_ctrl_dependientes_economicos_hraes =
                                ctrl_dependientes_economicos_hraes.id_ctrl_dependientes_economicos_hraes
                            WHERE ctrl_dependientes_economicos_hraes.curp = '$curp'
                            AND ctrl_juguetes_hraes.id_cat_fecha_juguetes = $id_cat_fecha
                            AND ctrl_juguetes_hraes.id_ctrl_juguetes_hraes <> $id_object;");
        return $listado;
    }
    */
}
