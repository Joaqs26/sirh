<?php

class ModelFormaPagoM
{
    public function validarEstatus($value,$id_object,$id_tbl_empleados_hraes){
        $result ="";
        if($id_object != ''){
            $result = "AND id_ctrl_cuenta_clabe_hraes != $id_object;";
        }
        $listado = pg_query("SELECT COUNT(id_ctrl_cuenta_clabe_hraes)
                             FROM public.ctrl_cuenta_clabe_hraes
                             WHERE id_tbl_empleados_hraes = $id_tbl_empleados_hraes
                             AND id_cat_estatus = $value " . $result);
        return $listado;
    }
    function listarById($id_object,$paginator)
    {
        $listado = pg_query("SELECT ctrl_cuenta_clabe_hraes.id_ctrl_cuenta_clabe_hraes,
                                    ctrl_cuenta_clabe_hraes.clabe,
                                    cat_banco.nombre,
                                    cat_formato_pago.forma_pago,
                                    cat_estatus.estatus
                            FROM public.ctrl_cuenta_clabe_hraes
                            INNER JOIN cat_banco
                            ON ctrl_cuenta_clabe_hraes.id_cat_banco = 
                                cat_banco.id_cat_banco
                            INNER JOIN cat_formato_pago
                            ON ctrl_cuenta_clabe_hraes.id_cat_formato_pago = 
                                cat_formato_pago.id_cat_formato_pago
                            INNER JOIN cat_estatus
                            ON ctrl_cuenta_clabe_hraes.id_cat_estatus =
                                cat_estatus.id_cat_estatus
                            WHERE ctrl_cuenta_clabe_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY cat_estatus.estatus ASC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByBusqueda($id_object, $busqueda,$paginator)
    {
        $listado = pg_query("SELECT ctrl_cuenta_clabe_hraes.id_ctrl_cuenta_clabe_hraes,
                                    ctrl_cuenta_clabe_hraes.clabe,
                                    cat_banco.nombre,
                                    cat_formato_pago.forma_pago,
                                    cat_estatus.estatus
                            FROM public.ctrl_cuenta_clabe_hraes
                            INNER JOIN cat_banco
                            ON ctrl_cuenta_clabe_hraes.id_cat_banco = 
                                cat_banco.id_cat_banco
                            INNER JOIN cat_formato_pago
                            ON ctrl_cuenta_clabe_hraes.id_cat_formato_pago = 
                                cat_formato_pago.id_cat_formato_pago
                            INNER JOIN cat_estatus
                            ON ctrl_cuenta_clabe_hraes.id_cat_estatus =
                                cat_estatus.id_cat_estatus
                            WHERE ctrl_cuenta_clabe_hraes.id_tbl_empleados_hraes = $id_object
                            AND (
                                TRIM(UPPER(UNACCENT(ctrl_cuenta_clabe_hraes.clabe))) LIKE '%$busqueda%'
                             OR TRIM(UPPER(UNACCENT(cat_banco.nombre))) LIKE '%$busqueda%'
                             OR TRIM(UPPER(UNACCENT(cat_formato_pago.forma_pago))) LIKE  '%$busqueda%'
                             OR TRIM(UPPER(UNACCENT(cat_estatus.estatus))) LIKE '%$busqueda%'
                            )
                            ORDER BY cat_estatus.estatus ASC
                            LIMIT 3 OFFSET $paginator;");
        return $listado;
    }

    function listarByIdFormaPago($id_object){
        $listado = pg_query("SELECT id_ctrl_cuenta_clabe_hraes, clabe, id_cat_estatus,
                                    id_cat_banco,id_tbl_empleados_hraes,id_cat_formato_pago
                             FROM public.ctrl_cuenta_clabe_hraes
                             WHERE id_ctrl_cuenta_clabe_hraes = $id_object");
        return $listado;
    }

    function listarByNull()
    {
        return $raw = [
            'id_ctrl_cuenta_clabe_hraes' => null,
            'clabe' => null,
            'id_cat_estatus' => null,
            'id_cat_banco' => null,
            'id_tbl_empleados' => null,
            'id_cat_formato_pago' => null
        ];
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_cuenta_clabe_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_cuenta_clabe_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_cuenta_clabe_hraes', $condicion);
        return $pgs_delete;
    }

}
