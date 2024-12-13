<?php

class ModelLicenciasM
{

    public function validarEstatus($value,$id_object,$id_tbl_empleados_hraes){
        $result ="";
        if($id_object != ''){
            $result = "AND id_ctrl_incidencias_licencias_hraes != $id_object;";
        }
        $listado = pg_query("SELECT COUNT(id_ctrl_incidencias_licencias_hraes)
                             FROM public.ctrl_incidencias_licencias_hraes
                             WHERE id_tbl_empleados_hraes = $id_tbl_empleados_hraes
                             AND id_cat_estatus_incidencias = $value " . $result);
        return $listado;
    }

    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT 
                                ctrl_incidencias_licencias_hraes.id_ctrl_incidencias_licencias_hraes,
                                ctrl_incidencias_licencias_hraes.fecha_desde,
                                ctrl_incidencias_licencias_hraes.fecha_hasta,
                                ctrl_incidencias_licencias_hraes.fecha_registro,
                                ctrl_incidencias_licencias_hraes.fecha_inicio_nom,
                                ctrl_incidencias_licencias_hraes.fecha_fin_nomina,
                                ctrl_incidencias_licencias_hraes.horas_max_dia,
                                ctrl_incidencias_licencias_hraes.observaciones,
                                cat_tipo_dias.nombre,
                                cat_tipo_licencia.nombre,
                                cat_estatus_incidencias.nombre
                            FROM public.ctrl_incidencias_licencias_hraes
                            INNER JOIN cat_tipo_dias
                                ON public.ctrl_incidencias_licencias_hraes.id_cat_tipo_dias =
                                cat_tipo_dias.id_cat_tipo_dias
                            INNER JOIN cat_tipo_licencia
                                ON public.ctrl_incidencias_licencias_hraes.id_cat_tipo_licencia =
                                cat_tipo_licencia.id_cat_tipo_licencia
                            INNER JOIN cat_estatus_incidencias
                                ON public.ctrl_incidencias_licencias_hraes.id_cat_estatus_incidencias =
                                cat_estatus_incidencias.id_cat_estatus_incidencias
                            WHERE public.ctrl_incidencias_licencias_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY public.ctrl_incidencias_licencias_hraes.id_ctrl_incidencias_licencias_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByBusqueda($id_object, $busqueda, $paginator)
    {
        $listado = pg_query("SELECT 
                                ctrl_incidencias_licencias_hraes.id_ctrl_incidencias_licencias_hraes,
                                ctrl_incidencias_licencias_hraes.fecha_desde,
                                ctrl_incidencias_licencias_hraes.fecha_hasta,
                                ctrl_incidencias_licencias_hraes.fecha_registro,
                                ctrl_incidencias_licencias_hraes.fecha_inicio_nom,
                                ctrl_incidencias_licencias_hraes.fecha_fin_nomina,
                                ctrl_incidencias_licencias_hraes.horas_max_dia,
                                ctrl_incidencias_licencias_hraes.observaciones,
                                cat_tipo_dias.nombre AS nombre_tipo_dias,
                                cat_tipo_licencia.nombre AS nombre_tipo_licencia,
                                cat_estatus_incidencias.nombre
                            FROM 
                                public.ctrl_incidencias_licencias_hraes
                            INNER JOIN 
                                cat_tipo_dias ON ctrl_incidencias_licencias_hraes.id_cat_tipo_dias = cat_tipo_dias.id_cat_tipo_dias
                            INNER JOIN 
                                cat_tipo_licencia ON ctrl_incidencias_licencias_hraes.id_cat_tipo_licencia = cat_tipo_licencia.id_cat_tipo_licencia
                            INNER JOIN cat_estatus_incidencias
                                ON public.ctrl_incidencias_licencias_hraes.id_cat_estatus_incidencias =
                                cat_estatus_incidencias.id_cat_estatus_incidencias
                            WHERE 
                                ctrl_incidencias_licencias_hraes.id_tbl_empleados_hraes = $id_object
                                AND (
                                    TRIM(UPPER(UNACCENT(ctrl_incidencias_licencias_hraes.fecha_desde::TEXT))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(ctrl_incidencias_licencias_hraes.fecha_hasta::TEXT))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(ctrl_incidencias_licencias_hraes.fecha_registro::TEXT))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(ctrl_incidencias_licencias_hraes.fecha_inicio_nom::TEXT))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(ctrl_incidencias_licencias_hraes.fecha_fin_nomina::TEXT))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(ctrl_incidencias_licencias_hraes.horas_max_dia::TEXT))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(ctrl_incidencias_licencias_hraes.observaciones))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(cat_tipo_dias.nombre))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(cat_estatus_incidencias.nombre))) LIKE '%$busqueda%' OR 
                                    TRIM(UPPER(UNACCENT(cat_tipo_licencia.nombre))) LIKE '%$busqueda%'
                                )
                            ORDER BY 
                                cat_estatus_incidencias.nombre DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT *
                             FROM public.ctrl_incidencias_licencias_hraes
                             WHERE id_ctrl_incidencias_licencias_hraes = $id_object");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_incidencias_licencias_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_incidencias_licencias_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_incidencias_licencias_hraes', $condicion);
        return $pgs_delete;
    }

    function listarByNull()
    {
        return $raw = [
            'id_ctrl_incidencias_licencias_hraes' => null,
            'fecha_desde' => null,
            'fecha_hasta' => null,
            'fecha_registro' => null,
            'fecha_inicio_nom' => null,
            'fecha_fin_nomina' => null,
            'horas_max_dia' => null,
            'observaciones' => null,
            'id_tbl_empleados_hraes' => null,
            'id_cat_tipo_dias' => null,
            'id_cat_tipo_licencia' => null,
        ];
    }
}
