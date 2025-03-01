<?php

class modelEmpleadosHraes
{

    public function validarCurp($value, $id_object)
    {
        $result = "";
        if ($id_object != '') {
            $result = "AND id_tbl_empleados_hraes != $id_object;";
        }
        $listado = pg_query("SELECT COUNT(id_tbl_empleados_hraes)
                             FROM tbl_empleados_hraes
                             WHERE curp = '$value' " . $result);
        return $listado;
    }

    public function validarRfc($value, $id_object)
    {
        $result = "";
        if ($id_object != '') {
            $result = "AND id_tbl_empleados_hraes != $id_object;";
        }
        $listado = pg_query("SELECT COUNT(id_tbl_empleados_hraes)
                             FROM tbl_empleados_hraes
                             WHERE rfc = '$value' " . $result);
        return $listado;
    }

    public function validarNoEmpleado($value, $id_object)
    {
        $result = "";
        if ($id_object != '') {
            $result = "AND id_tbl_empleados_hraes != $id_object;";
        }
        $listado = pg_query("SELECT COUNT(id_tbl_empleados_hraes)
                             FROM tbl_empleados_hraes
                             WHERE num_empleado = '$value' " . $result);
        return $listado;
    }

    public function listarByAll($paginador)
    {
        $query = "SELECT 
            e.id_tbl_empleados_hraes, 
            cp.num_plaza, 
            ce.entidad AS zona_pagadora,
            e.rfc, 
            e.curp, 
            e.nombre, 
            e.primer_apellido,
            e.segundo_apellido, 
            m.codigo AS codigo_mov, 
            m.nombre_movimiento AS nombre_movimiento,
            ct.clave_centro_trabajo, 
            ct.nombre AS nombre_centro,
            cc.clabe AS clabe,
            e.num_empleado,
            pe.fecha_movimiento
    
        FROM central.tbl_empleados_hraes e
    
        LEFT JOIN central.tbl_plazas_empleados_hraes pe 
            ON e.id_tbl_empleados_hraes = pe.id_tbl_empleados_hraes
    
        LEFT JOIN central.tbl_control_plazas_hraes cp 
            ON pe.id_tbl_control_plazas_hraes = cp.id_tbl_control_plazas_hraes
    
        LEFT JOIN central.tbl_centro_trabajo_hraes ct 
            ON cp.id_tbl_centro_trabajo_hraes = ct.id_tbl_centro_trabajo_hraes
    
        LEFT JOIN public.cat_entidad ce 
            ON ct.id_cat_entidad = ce.id_cat_entidad
    
        LEFT JOIN public.tbl_movimientos m 
            ON pe.id_tbl_movimientos = m.id_tbl_movimientos
    
        LEFT JOIN central.ctrl_cuenta_clabe_hraes cc 
            ON e.id_tbl_empleados_hraes = cc.id_tbl_empleados_hraes
    
        ORDER BY pe.fecha_movimiento asc
        LIMIT 10;";
    
        return $query;
    }
    
    public function listarByLike($busqueda, $paginador)
{
    $result = " (TRIM(UPPER(UNACCENT(cp.num_plaza))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(ce.entidad))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(e.rfc))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(e.curp))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(e.nombre))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(e.primer_apellido))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(e.segundo_apellido))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(CONCAT(m.codigo, ' - ', m.nombre_movimiento)))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(CONCAT(ct.clave_centro_trabajo, ' - ', ct.nombre)))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(cc.clabe))) LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(e.num_empleado))) LIKE '%$busqueda%')
                ORDER BY pe.fecha_movimiento DESC
                LIMIT 6 OFFSET $paginador;";

    $listado = "SELECT 
                    e.id_tbl_empleados_hraes, 
                    cp.num_plaza, 
                    ce.entidad AS zona_pagadora,
                    e.rfc, 
                    e.curp, 
                    e.nombre, 
                    e.primer_apellido,
                    e.segundo_apellido, 
                    m.codigo AS codigo_mov, 
                    m.nombre_movimiento AS nombre_movimiento,
                    ct.clave_centro_trabajo, 
                    ct.nombre AS nombre_centro,
                    cc.clabe AS clabe,
                    e.num_empleado,
                    pe.fecha_movimiento

                FROM central.tbl_empleados_hraes e

                LEFT JOIN central.tbl_plazas_empleados_hraes pe 
                    ON e.id_tbl_empleados_hraes = pe.id_tbl_empleados_hraes
                    AND pe.fecha_movimiento = (
                        SELECT MAX(pe2.fecha_movimiento) 
                        FROM central.tbl_plazas_empleados_hraes pe2
                        WHERE pe2.id_tbl_empleados_hraes = e.id_tbl_empleados_hraes
                    )

                LEFT JOIN central.tbl_control_plazas_hraes cp 
                    ON pe.id_tbl_control_plazas_hraes = cp.id_tbl_control_plazas_hraes

                LEFT JOIN central.tbl_centro_trabajo_hraes ct 
                    ON cp.id_tbl_centro_trabajo_hraes = ct.id_tbl_centro_trabajo_hraes

                LEFT JOIN public.cat_entidad ce 
                    ON ct.id_cat_entidad = ce.id_cat_entidad

                LEFT JOIN public.tbl_movimientos m 
                    ON pe.id_tbl_movimientos = m.id_tbl_movimientos
                    AND m.id_tipo_movimiento <> 3 -- Excluir bajas

                LEFT JOIN central.ctrl_cuenta_clabe_hraes cc 
                    ON e.id_tbl_empleados_hraes = cc.id_tbl_empleados_hraes
                    AND (cc.id_cat_estatus = 1 OR cc.id_cat_estatus IS NULL) 
                
                WHERE " . $result;

    return $listado;
}


    
    public function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT id_tbl_empleados_hraes, rfc, curp, nombre, primer_apellido,
                                    segundo_apellido, nss,num_empleado,nacionalidad,
                                    id_cat_estado_civil,id_cat_genero_hraes,id_cat_pais_nacimiento,
                                    id_cat_estado_nacimiento
                            FROM central.tbl_empleados_hraes
                            WHERE id_tbl_empleados_hraes = $id_object
                            ORDER BY id_tbl_empleados_hraes DESC
                            LIMIT 6");
        return $listado;
    }

    public function listarByNull()
    {
        return $array = [
            'id_tbl_empleados_hraes' => null,
            'rfc' => null,
            'curp' => null,
            'nombre' => null,
            'primer_apellido' => null,
            'segundo_apellido' => null,
            'nss' => null,
            'num_empleado' => null,
            'nacionalidad' => null,
            'id_cat_estado_civil' => null,
            'id_cat_genero' => null,
            'id_cat_pais_nacimiento' => null,
            'id_cat_estado_nacimiento' => null,
        ];
    }

    function editarByArray($conexion, $datos, $condicion)
    {
        $pg_update = pg_update($conexion, 'central.tbl_empleados_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'central.tbl_empleados_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'central.tbl_empleados_hraes', $condicion);
        return $pgs_delete;
    }

    function empleadosCountAll(){
        $listado = pg_query("SELECT COUNT (id_tbl_empleados_hraes)
                             FROM central.tbl_empleados_hraes;");
        return $listado;
    }

    function generoEmpleados($condition){
        $listado = pg_query("SELECT COUNT(id_tbl_empleados_hraes)
                             FROM central.tbl_empleados_hraes
                             WHERE SUBSTRING(curp,11,1) = '$condition';");
        return $listado;
    }

    public function numEmpleado($idEmpleado){
        $listado = pg_query("SELECT split_part(num_empleado, '-', 1)
                             FROM tbl_empleados_hraes
                             WHERE id_tbl_empleados_hraes = $idEmpleado");

        return $listado;
    }
}
