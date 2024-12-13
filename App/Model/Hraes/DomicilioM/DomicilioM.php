<?php

class ModelDomicilioM{

    public function selectCountById($id_object){
        $listado = pg_query("SELECT COUNT (id_tbl_domicilios_hraes)
                             FROM public.tbl_domicilios_hraes
                             WHERE id_tbl_empleados_hraes =  $id_object");
        return $listado;
    }

    public function listarByIdEdit($id_object){
        $listado = pg_query("SELECT *
                            FROM public.tbl_domicilios_hraes
                            WHERE id_tbl_empleados_hraes = $id_object");
        return $listado;
    }

    public function listarByNull(){
        return $array = [
            'id_tbl_domicilios_hraes' => null,
            'id_tbl_datos_empleado_hraes' => null,
            'entidad1' => null,
            'municipio1' => null,
            'colonia1' => null,
            'codigo_postal1' => null,
            'calle1' => null,
            'num_exterior1' => null,
            'num_interior1' => null,
            'id_estatus1' => null,
            'entidad2' => null,
            'municipio2' => null,
            'colonia2' => null,
            'codigo_postal2' => null,
            'calle2' => null,
            'num_exterior2' => null,
            'num_interior2' => null,
            'id_estatus2' => null,
            'esdireccion_fiscal1' => null,
            'esdireccion_fiscal2' => null,
        ];
    }

    function editarByArray($conexion, $datos, $condicion){
        $pg_update = pg_update($conexion, 'public.tbl_domicilios_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos){
        $pg_add = pg_insert($conexion, 'public.tbl_domicilios_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion){
        $pgs_delete = pg_delete($conexion,'public.tbl_domicilios_hraes',$condicion);
        return $pgs_delete;
    }
}
