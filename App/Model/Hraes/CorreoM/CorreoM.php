<?php

class ModelCorreoM
{
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT id_ctrl_medios_contacto_hraes, correo_electronico
                            FROM public.ctrl_medios_contacto_hraes
                            WHERE id_tbl_empleados_hraes = $id_object
                            ORDER BY id_ctrl_medios_contacto_hraes DESC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT id_ctrl_medios_contacto_hraes, correo_electronico
                             FROM public.ctrl_medios_contacto_hraes
                             WHERE id_tbl_empleados_hraes = $id_object
                             AND TRIM(UPPER(UNACCENT(correo_electronico)))
                                 LIKE '%$busqueda%'
                             ORDER BY id_ctrl_medios_contacto_hraes DESC 
                             LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_medios_contacto_hraes, correo_electronico
                             FROM public.ctrl_medios_contacto_hraes
                             WHERE id_ctrl_medios_contacto_hraes = $id_object");
        return $listado;
    }

    function listarByNull()
    {
        return $raw = [
            'id_ctrl_medios_contacto_hraes' => null,
            'correo_electronico' => null,
        ];
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_medios_contacto_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_medios_contacto_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_medios_contacto_hraes', $condicion);
        return $pgs_delete;
    }
}
