<?php

class LenguaM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT 
                                public.ctrl_lengua.id_ctrl_lengua,
                                CONCAT(public.cat_lengua.identificador,' ', public.cat_lengua.descripcion)
                            FROM public.ctrl_lengua
                            INNER JOIN public.cat_lengua
                                ON public.cat_lengua.id_cat_lengua =
                                    public.ctrl_lengua.id_cat_lengua
                            WHERE public.ctrl_lengua.id_tbl_empleados_hraes = $id_object
                            ORDER BY public.ctrl_lengua.id_ctrl_lengua DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT 
                                public.ctrl_lengua.id_ctrl_lengua,
                                CONCAT(public.cat_lengua.identificador,' ', public.cat_lengua.descripcion)
                            FROM public.ctrl_lengua
                            INNER JOIN public.cat_lengua
                                ON public.cat_lengua.id_cat_lengua =
                                    public.ctrl_lengua.id_cat_lengua
                            WHERE public.ctrl_lengua.id_tbl_empleados_hraes = $id_object
                            AND TRIM(UPPER(UNACCENT(CONCAT(public.cat_lengua.identificador,' ', 
                                public.cat_lengua.descripcion)))) LIKE '%$busqueda%'
                            ORDER BY public.ctrl_lengua.id_ctrl_lengua DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT *
                             FROM public.ctrl_lengua
                             WHERE public.ctrl_lengua.id_ctrl_lengua = $id_object");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_lengua', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_lengua', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_lengua', $condicion);
        return $pgs_delete;
    }

}
