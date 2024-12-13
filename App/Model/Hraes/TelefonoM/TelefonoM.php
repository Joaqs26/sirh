<?php

class ModelTelefonoM
{
    public function validarEstatus($value,$id_object,$id_tbl_empleados_hraes){
        $result ="";
        if($id_object != ''){
            $result = "AND id_ctrl_telefono_hraes != $id_object;";
        }
        $listado = pg_query("SELECT COUNT(id_ctrl_telefono_hraes)
                             FROM public.ctrl_telefono_hraes
                             WHERE id_tbl_empleados_hraes = $id_tbl_empleados_hraes
                             AND id_cat_estatus = $value " . $result);
        return $listado;
    }
    function listarById($id_object, $paginator)
    {
        $listado = pg_query("SELECT ctrl_telefono_hraes.id_ctrl_telefono_hraes, 
                                    ctrl_telefono_hraes.movil, 
                                    ctrl_telefono_hraes.telefono, 
                                    cat_estatus.estatus,
                                    ctrl_telefono_hraes.id_tbl_empleados_hraes
                            FROM public.ctrl_telefono_hraes
                            INNER JOIN cat_estatus
                            ON ctrl_telefono_hraes.id_cat_estatus = cat_estatus.id_cat_estatus
                            WHERE ctrl_telefono_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY cat_estatus.estatus ASC 
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT ctrl_telefono_hraes.id_ctrl_telefono_hraes, 
                                    ctrl_telefono_hraes.movil, 
                                    ctrl_telefono_hraes.telefono, 
                                    cat_estatus.estatus,
                                    ctrl_telefono_hraes.id_tbl_empleados_hraes
                             FROM public.ctrl_telefono_hraes
                             INNER JOIN cat_estatus
                             ON ctrl_telefono_hraes.id_cat_estatus = cat_estatus.id_cat_estatus
                             WHERE ctrl_telefono_hraes.id_tbl_empleados_hraes = $id_object
                             AND ((ctrl_telefono_hraes.movil::TEXT) LIKE '%$busqueda%' 
                             OR (ctrl_telefono_hraes.telefono::TEXT) LIKE '%$busqueda%'
                             OR cat_estatus.estatus LIKE '%$busqueda%')
                             ORDER BY cat_estatus.estatus ASC 
                             LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByNull()
    {
        return $raw = [
            'id_ctrl_telefono_hraes' => null,
            'movil' => null,
            'telefono' => null,
            'id_cat_estatus' => null,
            'id_tbl_empleados_hraes' => null,
        ];
    }

    function listarEditById($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_telefono_hraes,movil,id_cat_estatus,
                             id_tbl_empleados_hraes,telefono
                             FROM public.ctrl_telefono_hraes
                             WHERE id_ctrl_telefono_hraes = $id_object");
        return $listado;
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_telefono_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_telefono_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_telefono_hraes', $condicion);
        return $pgs_delete;
    }
}
