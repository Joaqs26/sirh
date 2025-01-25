<?php

class modelDatosEmpleadoM{

    public function countDatosEmpleado($id_object){
        $listado = pg_query("SELECT COUNT (*)
                             FROM tbl_empleados_hraes
                             WHERE id_tbl_empleados_hraes = $id_object;");
        return $listado;
    }

    public function listarByIdEdit($id_object){
        $listado = pg_query("SELECT  nacionalidad, id_tbl_empleados_hraes, 
                                id_cat_genero_hraes, id_cat_estado_civil
                                FROM tbl_empleados_hraes
                                WHERE id_tbl_empleados_hraes = $id_object");
        return $listado;
    }

    public function listarByNull(){
        return $array = [
            'id_tbl_datos_empleado_hraes' => null,
            'pais_nacimiento' => null,
            'id_tbl_empleados_hraes' => null,
            'id_cat_genero_hraes' => null,
            'id_cat_estado_civil_hraes' => null
        ];
    }

    function editarByArray($conexion, $datos, $condicion){
        $pg_update = pg_update($conexion, 'tbl_empleados_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos){
        $pg_add = pg_insert($conexion, 'tbl_empleados_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion){
        $pgs_delete = pg_delete($conexion,'tbl_empleados_hraes',$condicion);
        return $pgs_delete;
    }

    /*
    public function listarByAll(){
        $listado = "SELECT id_tbl_empleados_hraes, rfc, curp, nombre, primer_apellido,
                           segundo_apellido, nss
                    FROM ctrl_campos_pers_hraes
                    ORDER BY id_ctrl_campos_pers_hraes DESC
                    LIMIT 6";

        return $listado;
    }

    public function listarByIdEdit($id_object){
        $listado = pg_query("SELECT *
                            FROM ctrl_campos_pers_hraes
                            WHERE id_tbl_empleados_hraes = $id_object
                            ORDER BY id_ctrl_campos_pers_hraes DESC
                            LIMIT 6");
        return $listado;
    }

    public function listarByNull(){
        return $array = [
            'id_tbl_empleados_hraes' => null,
            'rfc' => null,
            'curp' => null,
            'nombre' => null,
            'primer_apellido' => null,
            'segundo_apellido' => null,
            'nss' => null,
        ];
    }

    function editarByArray($conexion, $datos, $condicion){
        $pg_update = pg_update($conexion, 'ctrl_campos_pers_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos){
        $pg_add = pg_insert($conexion, 'tbl_empleados_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion){
        $pgs_delete = pg_delete($conexion,'tbl_empleados_hraes',$condicion);
        return $pgs_delete;
    }*/

}
