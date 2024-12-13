<?php

class ModelQuinquenioM
{

    public function listarById($id_object)
    {
        $listado = pg_query("SELECT ctrl_percepciones_quin_hraes.id_ctrl_percepciones_quin_hraes,
                                    ctrl_percepciones_quin_hraes.fecha_registro,
                                    cat_quinquenio.importe
                            FROM public.ctrl_percepciones_quin_hraes
                            INNER JOIN cat_quinquenio
                            ON public.ctrl_percepciones_quin_hraes.id_cat_quinquenio =
                                cat_quinquenio.id_cat_quinquenio
                            WHERE ctrl_percepciones_quin_hraes.id_tbl_empleados_hraes = $id_object
                            ORDER BY ctrl_percepciones_quin_hraes.id_ctrl_percepciones_quin_hraes DESC
                            LIMIT 3;");
        return $listado;
    }

    public function listarByNull()
    {
        return $raw = [
            'id_ctrl_percepciones_quin_hraes' => null,
            'id_tbl_empleados_hraes' => null,
            'id_cat_quinquenio' => null,
            'fecha_registro' => null
        ];
    }

    public function listarEditById($id_object)
    {
        $listado = pg_query("SELECT id_ctrl_percepciones_quin_hraes,id_tbl_empleados_hraes,
                                    id_cat_quinquenio,fecha_registro
                             FROM public.ctrl_percepciones_quin_hraes
                             WHERE id_ctrl_percepciones_quin_hraes = $id_object");
        return $listado;
    }

    public function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'public.ctrl_percepciones_quin_hraes', $datos, $condicion);
        return $pg_update;
    }

    public function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.ctrl_percepciones_quin_hraes', $datos);
        return $pg_add;
    }

    public function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.ctrl_percepciones_quin_hraes', $condicion);
        return $pgs_delete;
    }

    function validarQuinquenio($id_tbl_empleados_hraes,$id_object)
    {
        $condition = ';'; //->separator
        if($id_object != null){
            $condition = ' AND id_ctrl_percepciones_quin_hraes <> ' . $id_object;
        }

        $listado = pg_query("SELECT COUNT (id_ctrl_percepciones_quin_hraes)
                             FROM public.ctrl_percepciones_quin_hraes
                             WHERE id_tbl_empleados_hraes = $id_tbl_empleados_hraes" . $condition);
        return $listado;
    }
}