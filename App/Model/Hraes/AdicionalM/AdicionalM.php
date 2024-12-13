<?php

class AdicionalM{

    public function selectCountById($id_object){
        $listado = pg_query("SELECT COUNT (id_ctrl_adic_emp_hraes)
                             FROM public.ctrl_adic_emp_hraes
                             WHERE id_tbl_empleados_hraes = $id_object;");
        return $listado;
    }

    public function listarByIdEdit($id_object){
        $listado = pg_query("SELECT id_ctrl_adic_emp_hraes,fecha_expedicion,fecha_ingreso_gob_fed,
                                    vigencia_del,vigencia_al,funciones,antiguedad,id_tbl_empleados_hraes
                            FROM public.ctrl_adic_emp_hraes
                            WHERE id_tbl_empleados_hraes = $id_object");
        return $listado;
    }

    public function listarByNull(){
        return $array = [
            'id_ctrl_adic_emp_hraes' => null,
            'fecha_expedicion' => null,
            'fecha_ingreso_gob_fed' => null,
            'vigencia_del' => null,
            'vigencia_al' => null,
            'funciones' => null,
            'antiguedad' => null,
            'id_tbl_empleados_hraes' => null,
        ];
    }

    function editarByArray($conexion,$name,$datos, $condicion){
        $pg_update = pg_update($conexion,$name, $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $name,$datos){
        $pg_add = pg_insert($conexion, $name, $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion,$name,$condicion){
        $pgs_delete = pg_delete($conexion,$name,$condicion);
    }
}
