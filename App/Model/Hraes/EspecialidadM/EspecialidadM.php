<?php

class ModelEspecialidadM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT ctrl_especialidad_hraes.id_ctrl_especialidad_hraes,
                                    cat_especialidad_hraes.especialidad,
                                    ctrl_especialidad_hraes.cedula
                            FROM public.ctrl_especialidad_hraes
                            INNER JOIN cat_especialidad_hraes
                            ON ctrl_especialidad_hraes.id_cat_especialidad_hraes =
                                cat_especialidad_hraes.id_cat_especialidad_hraes
                            WHERE ctrl_especialidad_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY ctrl_especialidad_hraes.id_ctrl_especialidad_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT ctrl_especialidad_hraes.id_ctrl_especialidad_hraes,
                                    cat_especialidad_hraes.especialidad,
                                    ctrl_especialidad_hraes.cedula
                            FROM public.ctrl_especialidad_hraes
                            INNER JOIN cat_especialidad_hraes
                            ON ctrl_especialidad_hraes.id_cat_especialidad_hraes =
                                cat_especialidad_hraes.id_cat_especialidad_hraes
                            WHERE ctrl_especialidad_hraes.id_tbl_empleados_hraes = $id_object
                            AND (TRIM(UPPER(UNACCENT(cat_especialidad_hraes.especialidad)))
                                LIKE '%$busqueda%' OR
                                TRIM(UPPER(UNACCENT(ctrl_especialidad_hraes.cedula)))
                                LIKE '%$busqueda%')
                            ORDER BY ctrl_especialidad_hraes.id_ctrl_especialidad_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_especialidad_hraes, id_tbl_empleados_hraes,
                                    id_cat_especialidad_hraes, cedula
                             FROM public.ctrl_especialidad_hraes
                             WHERE id_ctrl_especialidad_hraes = $id_object");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_especialidad_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_especialidad_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_especialidad_hraes', $condicion);
        return $pgs_delete;
    }
}
