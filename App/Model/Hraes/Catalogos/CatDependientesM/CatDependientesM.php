<?php

class CatDependientesM
{
    public function listarByAll($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_dependientes_economicos_hraes, curp, nombre,
                                    apellido_materno, apellido_paterno
                             FROM public.ctrl_dependientes_economicos_hraes
                             WHERE id_tbl_empleados_hraes = $id_object
                             ORDER BY nombre ASC");
        return $listado;
    }

    public function obtenerElemetoById($idObject)
    {
        $listado = pg_query("SELECT id_ctrl_dependientes_economicos_hraes, CONCAT(nombre, ' ', apellido_paterno,
                                    ' ',apellido_materno) 
                             FROM public.ctrl_dependientes_economicos_hraes
                             WHERE id_ctrl_dependientes_economicos_hraes = $idObject");
        return $listado;
    }

    public function obtenerElemetoByCurp($idObject)
    {
        $listado = pg_query("SELECT curp
                             FROM public.ctrl_dependientes_economicos_hraes
                             WHERE id_ctrl_dependientes_economicos_hraes = $idObject");
        return $listado;
    }
}
