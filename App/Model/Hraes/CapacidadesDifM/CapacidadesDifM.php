<?php

class ModelCapacidadesM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes,
                                cat_capacidad_dif_hraes.capacidad
                            FROM public.ctrl_capacidad_dif_hraes
                            INNER JOIN cat_capacidad_dif_hraes
                            ON ctrl_capacidad_dif_hraes.id_cat_capacidad_dif_hraes =	
                                cat_capacidad_dif_hraes.id_capacidad_dif_hraes
                            WHERE ctrl_capacidad_dif_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes DESC 
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    
    function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes,
                                cat_capacidad_dif_hraes.capacidad
                            FROM public.ctrl_capacidad_dif_hraes
                            INNER JOIN cat_capacidad_dif_hraes
                            ON ctrl_capacidad_dif_hraes.id_cat_capacidad_dif_hraes =	
                                cat_capacidad_dif_hraes.id_capacidad_dif_hraes
                            WHERE ctrl_capacidad_dif_hraes.id_tbl_empleados_hraes = $id_object
                            AND TRIM(UPPER(UNACCENT(cat_capacidad_dif_hraes.capacidad))) LIKE '%$busqueda%'
                            ORDER BY ctrl_capacidad_dif_hraes.id_ctrl_capacidad_dif_hraes DESC 
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

   
    function listarByIdCap($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_capacidad_dif_hraes, id_cat_capacidad_dif_hraes
                            FROM public.ctrl_capacidad_dif_hraes
                            WHERE id_ctrl_capacidad_dif_hraes = $id_object");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_capacidad_dif_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_capacidad_dif_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_capacidad_dif_hraes', $condicion);
        return $pgs_delete;
    }
}
