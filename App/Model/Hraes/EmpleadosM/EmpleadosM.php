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
        $query = "    SELECT 
                        public.tbl_empleados_hraes.id_tbl_empleados_hraes, 
                            CASE 
                                WHEN (SELECT EXISTS (
                                    SELECT TRUE
                                    FROM public.tbl_plazas_empleados_hraes
                                    INNER JOIN public.tbl_control_plazas_hraes
                                        ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                            public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                    INNER JOIN public.tbl_movimientos
                                    ON public.tbl_movimientos.id_tbl_movimientos = 
                                        public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                        WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                        SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                        FROM public.tbl_plazas_empleados_hraes
                                        WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                        AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                        AND public.tbl_movimientos.id_tipo_movimiento <> 3
                                )) = TRUE THEN public.tbl_control_plazas_hraes.num_plaza 
                                ELSE '-'
                                END AS num_plaza,
                                CASE 
                                WHEN (SELECT EXISTS (
                                    SELECT TRUE
                                    FROM public.tbl_plazas_empleados_hraes
                                    INNER JOIN public.tbl_control_plazas_hraes
                                        ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                            public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                    INNER JOIN public.tbl_movimientos
                                    ON public.tbl_movimientos.id_tbl_movimientos = 
                                        public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                        WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                        SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                        FROM public.tbl_plazas_empleados_hraes
                                        WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                        AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                        AND public.tbl_movimientos.id_tipo_movimiento <> 3
                                )) = TRUE THEN public.cat_entidad.entidad 
                                ELSE '-'
                                END AS zona_pagadora,
                            public.tbl_empleados_hraes.rfc, 
                            public.tbl_empleados_hraes.curp, 
                            public.tbl_empleados_hraes.nombre, 
                            public.tbl_empleados_hraes.primer_apellido,
                            public.tbl_empleados_hraes.segundo_apellido, 
                            CASE 
                                WHEN (SELECT EXISTS (
                                    SELECT TRUE
                                    FROM public.tbl_plazas_empleados_hraes
                                    INNER JOIN public.tbl_control_plazas_hraes
                                        ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                            public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                    INNER JOIN public.tbl_movimientos
                                    ON public.tbl_movimientos.id_tbl_movimientos = 
                                        public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                        WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                        SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                        FROM public.tbl_plazas_empleados_hraes
                                        WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                        AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                        AND public.tbl_movimientos.id_tipo_movimiento <> 3
                                )) = TRUE THEN CONCAT(public.tbl_movimientos.codigo, ' - ',
                                                    public.tbl_movimientos.nombre_movimiento) 
                                ELSE '-'
                                END AS movimiento,
                            CASE 
                                WHEN (SELECT EXISTS (
                                    SELECT TRUE
                                    FROM public.tbl_plazas_empleados_hraes
                                    INNER JOIN public.tbl_control_plazas_hraes
                                        ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                            public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                    INNER JOIN public.tbl_movimientos
                                    ON public.tbl_movimientos.id_tbl_movimientos = 
                                        public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                        WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                        SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                        FROM public.tbl_plazas_empleados_hraes
                                        WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                        AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                                public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                        AND public.tbl_movimientos.id_tipo_movimiento <> 3
                                )) = TRUE THEN CONCAT (public.tbl_centro_trabajo_hraes.clave_centro_trabajo, ' - ',
                                                        public.tbl_centro_trabajo_hraes.nombre)
                                ELSE '-'
                                END AS clue,
                                public.ctrl_cuenta_clabe_hraes.clabe AS clabe,
                                public.tbl_empleados_hraes.num_empleado
                    FROM public.tbl_empleados_hraes
                    LEFT JOIN public.tbl_plazas_empleados_hraes
                        ON public.tbl_empleados_hraes.id_tbl_empleados_hraes =
                            public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes
                    LEFT JOIN public.tbl_control_plazas_hraes
                            ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes	
                    LEFT JOIN public.tbl_centro_trabajo_hraes
                        ON public.tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes =
                            public.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes
                    LEFT JOIN public.cat_entidad
                        ON public.tbl_centro_trabajo_hraes.id_cat_entidad =
                            public.cat_entidad.id_cat_entidad
                    LEFT JOIN public.tbl_movimientos
                        ON public.tbl_plazas_empleados_hraes.id_tbl_movimientos =
                            public.tbl_movimientos.id_tbl_movimientos
                    LEFT JOIN public.ctrl_cuenta_clabe_hraes
                        ON public.tbl_empleados_hraes.id_tbl_empleados_hraes =
                            public.ctrl_cuenta_clabe_hraes.id_tbl_empleados_hraes
                    WHERE (public.tbl_plazas_empleados_hraes.fecha_movimiento = 
                        (SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                        FROM public.tbl_plazas_empleados_hraes
                        WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes 
                                        = public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                            OR public.tbl_plazas_empleados_hraes.fecha_movimiento IS NULL)	
                    AND (public.ctrl_cuenta_clabe_hraes.id_cat_estatus = 1 OR 
                        public.ctrl_cuenta_clabe_hraes.id_cat_estatus IS NULL)
                       LIMIT 6 OFFSET $paginador;";
        /*
        $listado = "SELECT id_tbl_empleados_hraes, rfc, curp, nombre, primer_apellido,
                           segundo_apellido, num_empleado
                    FROM public.tbl_empleados_hraes
                    ORDER BY id_tbl_empleados_hraes DESC
                    LIMIT 6 OFFSET $paginador;";

        return $listado;*/
    }

    public function listarByLike($busqueda, $paginador)
    {
        $query = "SELECT 
                    public.tbl_empleados_hraes.id_tbl_empleados_hraes, 
                        CASE 
                            WHEN (SELECT EXISTS (
                                SELECT TRUE
                                FROM public.tbl_plazas_empleados_hraes
                                INNER JOIN public.tbl_control_plazas_hraes
                                    ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                        public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                INNER JOIN public.tbl_movimientos
                                ON public.tbl_movimientos.id_tbl_movimientos = 
                                    public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                    WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                    SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                    FROM public.tbl_plazas_empleados_hraes
                                    WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                    AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                    AND public.tbl_movimientos.id_tipo_movimiento <> 3
                            )) = TRUE THEN public.tbl_control_plazas_hraes.num_plaza 
                            ELSE '-'
                            END AS num_plaza,
                            CASE 
                            WHEN (SELECT EXISTS (
                                SELECT TRUE
                                FROM public.tbl_plazas_empleados_hraes
                                INNER JOIN public.tbl_control_plazas_hraes
                                    ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                        public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                INNER JOIN public.tbl_movimientos
                                ON public.tbl_movimientos.id_tbl_movimientos = 
                                    public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                    WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                    SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                    FROM public.tbl_plazas_empleados_hraes
                                    WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                    AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                    AND public.tbl_movimientos.id_tipo_movimiento <> 3
                            )) = TRUE THEN public.cat_entidad.entidad 
                            ELSE '-'
                            END AS zona_pagadora,
                        public.tbl_empleados_hraes.rfc, 
                        public.tbl_empleados_hraes.curp, 
                        public.tbl_empleados_hraes.nombre, 
                        public.tbl_empleados_hraes.primer_apellido,
                        public.tbl_empleados_hraes.segundo_apellido, 
                        CASE 
                            WHEN (SELECT EXISTS (
                                SELECT TRUE
                                FROM public.tbl_plazas_empleados_hraes
                                INNER JOIN public.tbl_control_plazas_hraes
                                    ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                        public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                INNER JOIN public.tbl_movimientos
                                ON public.tbl_movimientos.id_tbl_movimientos = 
                                    public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                    WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                    SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                    FROM public.tbl_plazas_empleados_hraes
                                    WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                    AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                    AND public.tbl_movimientos.id_tipo_movimiento <> 3
                            )) = TRUE THEN CONCAT(public.tbl_movimientos.codigo, ' - ',
                                                public.tbl_movimientos.nombre_movimiento) 
                            ELSE '-'
                            END AS movimiento,
                        CASE 
                            WHEN (SELECT EXISTS (
                                SELECT TRUE
                                FROM public.tbl_plazas_empleados_hraes
                                INNER JOIN public.tbl_control_plazas_hraes
                                    ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                                        public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes
                                INNER JOIN public.tbl_movimientos
                                ON public.tbl_movimientos.id_tbl_movimientos = 
                                    public.tbl_plazas_empleados_hraes.id_tbl_movimientos
                                    WHERE public.tbl_plazas_empleados_hraes.fecha_movimiento = (
                                    SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                                    FROM public.tbl_plazas_empleados_hraes
                                    WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                                    AND public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                            public.tbl_empleados_hraes.id_tbl_empleados_hraes
                                    AND public.tbl_movimientos.id_tipo_movimiento <> 3
                            )) = TRUE THEN CONCAT (public.tbl_centro_trabajo_hraes.clave_centro_trabajo, ' - ',
                                                    public.tbl_centro_trabajo_hraes.nombre)
                            ELSE '-'
                            END AS clue,
                            public.ctrl_cuenta_clabe_hraes.clabe AS clabe,
                            public.tbl_empleados_hraes.num_empleado
                FROM public.tbl_empleados_hraes
                LEFT JOIN public.tbl_plazas_empleados_hraes
                    ON public.tbl_empleados_hraes.id_tbl_empleados_hraes =
                        public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes
                LEFT JOIN public.tbl_control_plazas_hraes
                        ON public.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes =
                            public.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes	
                LEFT JOIN public.tbl_centro_trabajo_hraes
                    ON public.tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes =
                        public.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes
                LEFT JOIN public.cat_entidad
                    ON public.tbl_centro_trabajo_hraes.id_cat_entidad =
                        public.cat_entidad.id_cat_entidad
                LEFT JOIN public.tbl_movimientos
                    ON public.tbl_plazas_empleados_hraes.id_tbl_movimientos =
                        public.tbl_movimientos.id_tbl_movimientos
                LEFT JOIN public.ctrl_cuenta_clabe_hraes
                    ON public.tbl_empleados_hraes.id_tbl_empleados_hraes =
                        public.ctrl_cuenta_clabe_hraes.id_tbl_empleados_hraes
                WHERE (public.tbl_plazas_empleados_hraes.fecha_movimiento = 
                    (SELECT MAX(public.tbl_plazas_empleados_hraes.fecha_movimiento) 
                    FROM public.tbl_plazas_empleados_hraes
                    WHERE public.tbl_plazas_empleados_hraes.id_tbl_empleados_hraes 
                                    = public.tbl_empleados_hraes.id_tbl_empleados_hraes)
                        OR public.tbl_plazas_empleados_hraes.fecha_movimiento IS NULL)	
                AND (public.ctrl_cuenta_clabe_hraes.id_cat_estatus = 1 OR 
                    public.ctrl_cuenta_clabe_hraes.id_cat_estatus IS NULL)
                AND (
                       TRIM(UPPER(UNACCENT(public.tbl_control_plazas_hraes.num_plaza))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.cat_entidad.entidad))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.tbl_empleados_hraes.rfc))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.tbl_empleados_hraes.curp))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.tbl_empleados_hraes.nombre))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.tbl_empleados_hraes.primer_apellido))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.tbl_empleados_hraes.segundo_apellido))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(CONCAT(public.tbl_movimientos.codigo, ' - ',
                                                public.tbl_movimientos.nombre_movimiento)))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(CONCAT (public.tbl_centro_trabajo_hraes.clave_centro_trabajo, ' - ',
                                                    public.tbl_centro_trabajo_hraes.nombre)))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.ctrl_cuenta_clabe_hraes.clabe))) LIKE '%$busqueda%' OR
                       TRIM(UPPER(UNACCENT(public.tbl_empleados_hraes.num_empleado))) LIKE '%$busqueda%')
                       LIMIT 6 OFFSET $paginador;";
        return $query;
        /*
        $listado = "SELECT id_tbl_empleados_hraes, rfc, curp, nombre, primer_apellido,
                           segundo_apellido,num_empleado
                    FROM public.tbl_empleados_hraes
                    WHERE TRIM(UPPER(UNACCENT(rfc))) LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(curp))) LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(nombre))) LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(primer_apellido))) LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(segundo_apellido))) LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(CAST(num_empleado AS TEXT)))) LIKE '%$busqueda%'
                    OR TRIM(UPPER(UNACCENT(CONCAT(nombre,' ',primer_apellido,' ',segundo_apellido))))
                        LIKE '%$busqueda%'
                    ORDER BY id_tbl_empleados_hraes DESC
                    LIMIT 6 OFFSET $paginador;";
        return $listado;
        */
    }

    public function listarByIdEdit($id_object)
    {
        $listado = pg_query("SELECT id_tbl_empleados_hraes, rfc, curp, nombre, primer_apellido,
                                    segundo_apellido, nss,num_empleado,nacionalidad,
                                    id_cat_estado_civil,id_cat_genero_hraes,id_cat_pais_nacimiento,
                                    id_cat_estado_nacimiento
                            FROM public.tbl_empleados_hraes
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
        $pg_update = pg_update($conexion, 'public.tbl_empleados_hraes', $datos, $condicion);
        return $pg_update;
    }

    function agregarByArray($conexion, $datos)
    {
        $pg_add = pg_insert($conexion, 'public.tbl_empleados_hraes', $datos);
        return $pg_add;
    }

    function eliminarByArray($conexion, $condicion)
    {
        $pgs_delete = pg_delete($conexion, 'public.tbl_empleados_hraes', $condicion);
        return $pgs_delete;
    }

    function empleadosCountAll(){
        $listado = pg_query("SELECT COUNT (id_tbl_empleados_hraes)
                             FROM public.tbl_empleados_hraes;");
        return $listado;
    }

    function generoEmpleados($condition){
        $listado = pg_query("SELECT COUNT(id_tbl_empleados_hraes)
                             FROM public.tbl_empleados_hraes
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
