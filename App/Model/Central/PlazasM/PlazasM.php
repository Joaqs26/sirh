<?php

class modelPlazasHraes
{
    public function listarByAll($id_tbl_centro_trabajo_hraes, $paginator)
{
    $result = "
        ORDER BY id_tbl_control_plazas_hraes DESC
        LIMIT 6 OFFSET $paginator;";

    if ($id_tbl_centro_trabajo_hraes != null) {
        $result = "
            WHERE tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes = $id_tbl_centro_trabajo_hraes
            ORDER BY tbl_control_plazas_hraes.id_tbl_control_plazas_hraes DESC
            LIMIT 6 OFFSET $paginator;";
    }

    $listado = "SELECT tbl_control_plazas_hraes.id_tbl_control_plazas_hraes,
                        tbl_control_plazas_hraes.num_plaza, 
                        cat_tipo_plazas.tipo_plaza,
                        central.cat_puesto_hraes.nombre_posicion,
                        central.cat_puesto_hraes.codigo_puesto,
                        central.cat_puesto_hraes.nivel,
                        central.tbl_centro_trabajo_hraes.clave_centro_trabajo,
                        central.cat_tipo_contratacion.descripcion,
                        cat_unidad.nombre,
                        central.tbl_control_plazas_hraes.id_user,
                        central.tbl_control_plazas_hraes.fecha_usuario
                FROM central.tbl_control_plazas_hraes
                INNER JOIN cat_tipo_plazas
                    ON tbl_control_plazas_hraes.id_cat_tipo_plazas = cat_tipo_plazas.id_cat_tipo_plazas
                INNER JOIN cat_unidad
                    ON tbl_control_plazas_hraes.id_cat_unidad = cat_unidad.id_cat_unidad
                INNER JOIN central.cat_puesto_hraes
                    ON central.tbl_control_plazas_hraes.id_cat_puesto_hraes =
                        central.cat_puesto_hraes.id_cat_puesto_hraes
                INNER JOIN central.tbl_centro_trabajo_hraes
                    ON central.tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes =
                        central.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes
                LEFT JOIN central.cat_tipo_contratacion
                    ON central.tbl_control_plazas_hraes.id_cat_tipo_contratacion =
                        central.cat_tipo_contratacion.id_cat_tipo_contratacion " . $result;
    return $listado;
}

public function listarByLike($id_tbl_centro_trabajo_hraes, $busqueda, $paginator)
{
    $result = " (TRIM(UPPER(UNACCENT(tbl_control_plazas_hraes.num_plaza))) 
                        LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(cat_tipo_plazas.tipo_plaza)))
                        LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(central.cat_puesto_hraes.nombre_posicion)))
                        LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(central.cat_puesto_hraes.codigo_puesto)))
                        LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(central.cat_puesto_hraes.nivel)))
                        LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(central.tbl_centro_trabajo_hraes.clave_centro_trabajo)))
                        LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(central.cat_tipo_contratacion.descripcion)))
                        LIKE '%$busqueda%'
                OR TRIM(UPPER(UNACCENT(cat_unidad.nombre)))
                        LIKE '%$busqueda%')
                ORDER BY id_tbl_control_plazas_hraes DESC
                LIMIT 6 OFFSET $paginator;";
                
    $condition = "";
    $value = ' WHERE ';
    if ($id_tbl_centro_trabajo_hraes != null) {
        $condition = "WHERE tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes = 
                    $id_tbl_centro_trabajo_hraes ";
        $value = ' AND ';
    }
    $condition = $condition . $value . $result;

    $listado = "SELECT tbl_control_plazas_hraes.id_tbl_control_plazas_hraes,
                        tbl_control_plazas_hraes.num_plaza, 
                        cat_tipo_plazas.tipo_plaza,
                        central.cat_puesto_hraes.nombre_posicion,
                        central.cat_puesto_hraes.codigo_puesto,
                        central.cat_puesto_hraes.nivel,
                        central.tbl_centro_trabajo_hraes.clave_centro_trabajo,
                        central.cat_tipo_contratacion.descripcion,
                        cat_unidad.nombre,
                        central.tbl_control_plazas_hraes.id_user,
                        central.tbl_control_plazas_hraes.fecha_usuario
                FROM central.tbl_control_plazas_hraes
                INNER JOIN cat_tipo_plazas
                    ON tbl_control_plazas_hraes.id_cat_tipo_plazas = cat_tipo_plazas.id_cat_tipo_plazas
                INNER JOIN cat_unidad
                    ON tbl_control_plazas_hraes.id_cat_unidad = cat_unidad.id_cat_unidad
                INNER JOIN central.cat_puesto_hraes
                    ON central.tbl_control_plazas_hraes.id_cat_puesto_hraes =
                        central.cat_puesto_hraes.id_cat_puesto_hraes
                INNER JOIN central.tbl_centro_trabajo_hraes
                    ON central.tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes =
                        central.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes
                LEFT JOIN central.cat_tipo_contratacion
                    ON central.tbl_control_plazas_hraes.id_cat_tipo_contratacion =
                        central.cat_tipo_contratacion.id_cat_tipo_contratacion " . $condition;
    
    return $listado;
}


            function detallesPlazas($id_object)
            {
                $listado = pg_query("SELECT tbl_control_plazas_hraes.id_tbl_control_plazas_hraes,
                                                tbl_control_plazas_hraes.num_plaza, 
                                                cat_tipo_plazas.tipo_plaza,
                                                cat_unidad.nombre,
                                                tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes,
                                                tbl_centro_trabajo_hraes.clave_centro_trabajo,
                                                tbl_centro_trabajo_hraes.nombre,
                                                cat_entidad.entidad, 
                                                tbl_centro_trabajo_hraes.codigo_postal
                                        FROM central.tbl_control_plazas_hraes
                                        INNER JOIN cat_tipo_plazas
                                        ON tbl_control_plazas_hraes.id_cat_tipo_plazas = cat_tipo_plazas.id_cat_tipo_plazas
                                        INNER JOIN cat_unidad
                                        ON tbl_control_plazas_hraes.id_cat_unidad = 
                                    cat_unidad.id_cat_unidad
                                        INNER JOIN central.tbl_centro_trabajo_hraes
                                        ON tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes = 
                                        tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes
                                        INNER JOIN cat_entidad
                                        ON tbl_centro_trabajo_hraes.id_cat_entidad = cat_entidad.id_cat_entidad
                                    WHERE tbl_control_plazas_hraes.id_tbl_control_plazas_hraes = $id_object");
                return $listado;
            }

            function listarHistoria($id_object)
            {
                $listado = "SELECT tbl_empleados_hraes.rfc,
                                            tbl_movimientos.nombre_movimiento,
                                            tbl_plazas_empleados_hraes.fecha_inicio,	
                                            tbl_plazas_empleados_hraes.fecha_termino,
                                            tbl_plazas_empleados_hraes.fecha_movimiento,
                                            tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes
                                    FROM central.tbl_plazas_empleados_hraes
                                    INNER JOIN tbl_movimientos
                                    ON tbl_plazas_empleados_hraes.id_tbl_movimientos = 
                                        tbl_movimientos.id_tbl_movimientos
                                    INNER JOIN central.tbl_empleados_hraes
                                    ON tbl_plazas_empleados_hraes.id_tbl_empleados_hraes = 
                                        tbl_empleados_hraes.id_tbl_empleados_hraes
                                    WHERE tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes = $id_object
                                    ORDER BY tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes DESC
                                    LIMIT 3;";
                return $listado;
            }

            function listarByIdEdit($id_object)
            {
                $listado = pg_query("SELECT *
                                    FROM central.tbl_control_plazas_hraes
                                    WHERE id_tbl_control_plazas_hraes = $id_object");
                return $listado;
            }

            public function listarCountByNum($numPlaza)
            {
                $listado = pg_query("SELECT COUNT (id_tbl_control_plazas_hraes)
                                    FROM central.tbl_control_plazas_hraes
                                    WHERE num_plaza = '$numPlaza';");
                return $listado;
            }

            public function listarNumPlazaUResp($numPlaza)
            {
                $listado = pg_query("SELECT tbl_control_plazas_hraes.id_tbl_control_plazas_hraes,
                                            tbl_control_plazas_hraes.id_cat_tipo_plazas,
                                            cat_tipo_plazas.tipo_plaza,
                                            cat_unidad.nombre
                                    FROM central.tbl_control_plazas_hraes
                                    INNER JOIN cat_tipo_plazas
                                    ON central.tbl_control_plazas_hraes.id_cat_tipo_plazas = 
                                        cat_tipo_plazas.id_cat_tipo_plazas
                                    INNER JOIN cat_unidad
                                    ON central.tbl_control_plazas_hraes.id_cat_unidad = 
                                        cat_unidad.id_cat_unidad    
                                    WHERE tbl_control_plazas_hraes.num_plaza = '$numPlaza';");
                return $listado;
            }

            function listarByNull()
            {
                return $raw = [
                    'id_tbl_control_plazas_hraes' => null,
                    'num_plaza' => null,
                    'id_cat_tipo_plazas' => null,
                    'id_cat_tipo_subtipo_contratacion_hraes' => null,
                    'id_cat_unidad' => null,
                    'id_tbl_centro_trabajo_hraes' => null,
                    'id_cat_puesto_hraes' => null,
                    'id_cat_zonas_tabuladores_hraes' => null,
                    'id_cat_niveles_hraes' => null,
                    'id_tbl_zonas_pago_hraes' => null,
                    'fecha_ingreso_inst' => null,
                    'fecha_inicio_movimiento' => null,
                    'fecha_termino_movimiento' => null,
                    'fecha_modificacion' => null,
                    'id_cat_situacion_plaza_hraes' => null
                ];
            }

            public function listarByEditMovimiento($id)
            {
                $listado = pg_query("SELECT tbl_control_plazas_hraes.num_plaza,
                                            cat_tipo_plazas.tipo_plaza,
                                            cat_unidad.nombre
                                    FROM central.tbl_control_plazas_hraes
                                    INNER JOIN cat_tipo_plazas
                                    ON central.tbl_control_plazas_hraes.id_cat_tipo_plazas =
                                        cat_tipo_plazas.id_cat_tipo_plazas
                                    INNER JOIN cat_unidad
                                    ON central.tbl_control_plazas_hraes.id_cat_unidad =
                                        cat_unidad.id_cat_unidad
                                    WHERE tbl_control_plazas_hraes.id_tbl_control_plazas_hraes = $id");
                return $listado;
            }

            function editarByArray($conexion, $datos, $condicion)
            {
                $pg_update = pg_update($conexion, 'central.tbl_control_plazas_hraes', $datos, $condicion);
                return $pg_update;
            }

            function agregarByArray($conexion, $datos)
            {
                $pg_add = pg_insert($conexion, 'central.tbl_control_plazas_hraes', $datos);
                return $pg_add;
            }

            function eliminarByArray($conexion, $condicion)
            {
                $pgs_delete = pg_delete($conexion, 'central.tbl_control_plazas_hraes', $condicion);
                return $pgs_delete;
            }

            public function ultimoMovimientoPlaza($id)
            {
                $listado = pg_query("SELECT tbl_movimientos.id_tipo_movimiento,
                                            tbl_plazas_empleados_hraes.id_tbl_plazas_empleados_hraes,
                                            tbl_plazas_empleados_hraes.id_tbl_empleados_hraes
                                    FROM central.tbl_plazas_empleados_hraes
                                    INNER JOIN tbl_movimientos
                                    ON central.tbl_plazas_empleados_hraes.id_tbl_movimientos =
                                        tbl_movimientos.id_tbl_movimientos
                                    WHERE central.tbl_plazas_empleados_hraes.id_tbl_control_plazas_hraes = $id
                                    ORDER BY tbl_plazas_empleados_hraes.fecha_movimiento DESC
                                    LIMIT 1;");
                return $listado;
            }

            public function allCountPlazas()
            {
                $listado = pg_query("SELECT COUNT (id_tbl_control_plazas_hraes)
                                    FROM central.tbl_control_plazas_hraes;");
                return $listado;
            }

            public function tipoPlazaAll($idCatPlaza)
            {
                $listado = pg_query("SELECT COUNT (id_tbl_control_plazas_hraes)
                                    FROM central.tbl_control_plazas_hraes
                                    WHERE id_cat_tipo_plazas = $idCatPlaza;");
                return $listado;
            }

            public function claveCentroTrabajo($idPlaza)
            {
                $listado = pg_query("SELECT tbl_centro_trabajo_hraes.clave_centro_trabajo
                                    FROM central.tbl_control_plazas_hraes
                                    INNER JOIN central.tbl_centro_trabajo_hraes
                                    ON  central.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes =
                                        central.tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes
                                    WHERE tbl_control_plazas_hraes.id_tbl_control_plazas_hraes = $idPlaza;");
                return $listado;
            }

            public function plazaVacante()
            {
                ////EL NUMERO 5 REPRESENTA LAS PLAZAS
                $listado = pg_query("SELECT id_tbl_control_plazas_hraes,num_plaza
                                    FROM central.tbl_control_plazas_hraes
                                    WHERE id_cat_tipo_plazas = 5
                                    ORDER BY num_plaza ASC;");
                return $listado;
            }

            public function plazaVacanteEdit($idPlaza)
            {
                ////EL NUMERO 5 REPRESENTA LAS PLAZAS
                $listado = pg_query("SELECT id_tbl_control_plazas_hraes,num_plaza
                                    FROM central.tbl_control_plazas_hraes  
                                    WHERE id_tbl_control_plazas_hraes = $idPlaza");
                return $listado;
            }

            public function infoPlazaCentro($idPlaza)
            {
                $listado = pg_query("SELECT 
            tbl_control_plazas_hraes.id_tbl_control_plazas_hraes,
            tbl_control_plazas_hraes.num_plaza,
            tbl_centro_trabajo_hraes.clave_centro_trabajo,
            tbl_control_plazas_hraes.id_cat_situacion_plaza_hraes
        FROM central.tbl_control_plazas_hraes
        INNER JOIN central.tbl_centro_trabajo_hraes
        ON tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes = tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes
        WHERE tbl_control_plazas_hraes.id_tbl_control_plazas_hraes = $idPlaza;");

                return $listado;
            }

            public function countNumPlaza($numPlaza)
            {
                $listado = pg_query("SELECT COUNT(id_tbl_control_plazas_hraes)
                                    FROM central.tbl_control_plazas_hraes
                                    WHERE TRIM(UPPER(num_plaza)) = TRIM(UPPER('$numPlaza'));");
                return $listado;
            }


            public function catUnidadAmninAll()
            {
                $query = pg_query("SELECT cat_plaza_unidad_adm.id_cat_plaza_unidad_adm,
                                            CONCAT(UPPER(cat_unidad.nombre), ' ', UPPER(cat_coordinacion.nombre))
                                    FROM cat_plaza_unidad_adm
                                    INNER JOIN cat_unidad
                                    ON cat_plaza_unidad_adm.id_cat_unidad =
                                        cat_unidad.id_cat_unidad
                                    INNER JOIN cat_coordinacion
                                    ON cat_plaza_unidad_adm.id_cat_coordinacion =
                                        cat_coordinacion.id_cat_coordinacion
                                    ORDER BY cat_unidad.nombre ASC;");
                return $query;
            }

            public function CatUnidadAmninEdit($id)
            {
                $query = pg_query("SELECT cat_plaza_unidad_adm.id_cat_plaza_unidad_adm,
                                            CONCAT(UPPER(cat_unidad.nombre), ' ', UPPER(cat_coordinacion.nombre))
                                    FROM cat_plaza_unidad_adm
                                    INNER JOIN cat_unidad
                                    ON cat_plaza_unidad_adm.id_cat_unidad =
                                        cat_unidad.id_cat_unidad
                                    INNER JOIN cat_coordinacion
                                    ON cat_plaza_unidad_adm.id_cat_coordinacion =
                                        cat_coordinacion.id_cat_coordinacion
                                    WHERE cat_plaza_unidad_adm.id_cat_plaza_unidad_adm = $id;");
                return $query;
            }

            public function getInfoPlaza($schema, $idPlaza)
            {
                $isQuery = pg_query("SELECT 
                                        $schema.tbl_control_plazas_hraes.num_plaza,
                                        cat_unidad.nombre,
                                        $schema.cat_puesto_hraes.codigo_puesto,
                                        $schema.cat_puesto_hraes.nivel,
                                        $schema.cat_puesto_hraes.nombre_posicion,
                                        $schema.tbl_centro_trabajo_hraes.clave_centro_trabajo,
                                        CONCAT(central.cat_entidad.clave_entidad, ' ', central.cat_entidad.entidad)
                                    FROM $schema.tbl_control_plazas_hraes
                                    INNER JOIN central.cat_unidad
                                        ON $schema.tbl_control_plazas_hraes.id_cat_unidad =	
                                            central.cat_unidad.id_cat_unidad
                                    INNER JOIN $schema.cat_puesto_hraes
                                        ON $schema.tbl_control_plazas_hraes.id_cat_puesto_hraes =
                                            $schema.cat_puesto_hraes.id_cat_puesto_hraes
                                    INNER JOIN $schema.tbl_centro_trabajo_hraes
                                        ON $schema.tbl_control_plazas_hraes.id_tbl_centro_trabajo_hraes =
                                            $schema.tbl_centro_trabajo_hraes.id_tbl_centro_trabajo_hraes
                                    INNER JOIN central.cat_entidad
                                        ON $schema.tbl_centro_trabajo_hraes.id_cat_entidad =
                                            central.cat_entidad.id_cat_entidad
                                    WHERE $schema.tbl_control_plazas_hraes.id_tbl_control_plazas_hraes = $idPlaza;");
                return $isQuery;
            }




            
            function Tabulador($id_object)
            {
                $listado = pg_query("SELECT 
                        cph.codigo_puesto,  -- Código de puesto agregado al inicio
                        t.sueldo_base, 
                        t.ayuda_gastos_actualizacion, 
                        t.asignacion_bruta, 
                        t.compensacion_servicios, 
                        t.compensacion_polivalencia, 
                        t.total_bruto_mensual, 
                        t.total_neto_mensual, 
                        t.sueldo_quincenal_neto,
                        t.zona_economica AS zona_economica_tabulador -- Zona económica del tabulador
                        FROM central.tbl_control_plazas_hraes p
                        LEFT JOIN central.tbl_centro_trabajo_hraes ccth
                            ON p.id_tbl_centro_trabajo_hraes = ccth.id_tbl_centro_trabajo_hraes
                        LEFT JOIN central.cat_puesto_hraes cph 
                            ON p.id_cat_puesto_hraes = cph.id_cat_puesto_hraes
                        LEFT JOIN public.cat_tabulador t
                            ON TRIM(cph.codigo_puesto) = TRIM(t.codigo_puesto_actual)
                            AND ccth.id_cat_zona_economica = t.zona_economica -- Verificación de zona económica
                        WHERE p.id_tbl_control_plazas_hraes = $id_object;");                                                       
                                                          
                                                             
                                                                
                                                                
                                                               
                return $listado;
            }


           
        }
